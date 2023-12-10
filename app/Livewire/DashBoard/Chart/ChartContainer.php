<?php

namespace App\Livewire\DashBoard\Chart;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use http\Params;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use PHPUnit\Util\Filter;
use function PHPUnit\Framework\stringContains;

class ChartContainer extends Component
{
//    private FilterType $filterType = FilterType::Last30Days;

    public array $dataSource = [];

    #[On('dofilter')]
    public function dofilter($state) {
        $_filter_type = FilterType::fromName($state['filter']);
        $_selected_categories = $state['categories'];
        $_selected_products = $state['products'];
        if ($_filter_type == FilterType::Custom) {
            $this->dataSource = $this->getDataSourceFromDB($_filter_type, $_selected_categories, $_selected_products, $state['dates'][0], $state['dates'][1]);
        } else {
            $this->dataSource = $this->getDataSourceFromDB($_filter_type, $_selected_categories, $_selected_products);
        }

        $this->dispatch('content_changed', $this->dataSource);
    }

    private function getDataSourceFromDB($filter_type, $categories=[], $products=[], $start_date=null, $end_date=null): array
    {
        $startDate = null;
        $endDate = null;
        $last_startDate = null;
        $last_endDate = null;
        $data_source = [];

        switch ($filter_type) {
            case FilterType::Today:
                $startDate = Carbon::now()->format('Y-m-d');
                $endDate = Carbon::now()->addDay(1)->format('Y-m-d');
                $last_startDate = Carbon::now()->subYear(1)->format('Y-m-d');
                $last_endDate = Carbon::now()->addDay(1)->subYear(1)->format('Y-m-d');
                break;
            case FilterType::Yesterday:
                $startDate = Carbon::now()->subDay(1)->format('Y-m-d');
                $endDate = Carbon::now()->format('Y-m-d');
                $last_startDate = Carbon::now()->subYear(1)->subDay(1)->format('Y-m-d');
                $last_endDate = Carbon::now()->subYear(1)->format('Y-m-d');
                break;
            case FilterType::Last7Days:
                $startDate = Carbon::now()->subDay(6)->format('Y-m-d');
                $endDate = Carbon::now()->addDay(1)->format('Y-m-d');
                $last_startDate = Carbon::now()->subYear(1)->subDay(6)->format('Y-m-d');
                $last_endDate = Carbon::now()->subYear(1)->addDay(1)->format('Y-m-d');
                break;
            case FilterType::Last30Days:
                $startDate = Carbon::now()->subDay(29)->format('Y-m-d');
                $endDate = Carbon::now()->addDay(1)->format('Y-m-d');
                $last_startDate = Carbon::now()->subYear(1)->subDay(29)->format('Y-m-d');
                $last_endDate = Carbon::now()->subYear(1)->addDay(1)->format('Y-m-d');
                break;
            case FilterType::ThisMonth:
                $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
                $endDate = Carbon::now()->addDay(1)->format('Y-m-d');
                $last_startDate = Carbon::now()->subYear(1)->startOfMonth()->format('Y-m-d');
                $last_endDate = Carbon::now()->subYear(1)->addDay(1)->format('Y-m-d');
                break;
            case FilterType::LastMonth:
                $startDate = Carbon::now()->subMonth(1)->startOfMonth()->format('Y-m-d');
                $endDate = Carbon::now()->subMonth(1)->endOfMonth()->addDay(1)->format('Y-m-d');
                $last_startDate = Carbon::now()->subYear(1)->subMonth(1)->startOfMonth()->format('Y-m-d');
                $last_endDate = Carbon::now()->subYear(1)->subMonth(1)->endOfMonth()->addDay(1)->format('Y-m-d');
                break;
            case FilterType::Custom:
                $startDate = Carbon::parse($start_date)->format('Y-m-d');
                $endDate = Carbon::parse($end_date)->addDay(1)->format('Y-m-d');
                $last_startDate = Carbon::parse($start_date)->subYear(1)->format('Y-m-d');
                $last_endDate = Carbon::parse($endDate)->subYear(1)->format('Y-m-d');
                break;
            default:
                $startDate = Carbon::now()->subDay(29)->format('Y-m-d');
                $endDate = Carbon::now()->addDay(1)->format('Y-m-d');
                $last_startDate = Carbon::now()->subYear(1)->subDay(29)->format('Y-m-d');
                $last_endDate = Carbon::now()->subYear(1)->addDay(1)->format('Y-m-d');
        }

        # this is the data source of the barchart - sales
        $this_year_profit = $this->getTotalProfitByOrderItems($startDate, $endDate, $categories, $products);
        $last_year_profit = $this->getTotalProfitByOrderItems($last_startDate, $last_endDate, $categories, $products);
        $data_source['sales'] = $this->getDataSource($this_year_profit, $last_year_profit, $filter_type, $startDate, $endDate);

        # this is the data source of the area chart - visitors
        $this_year_visitors = $this->getVistorsByOrders($startDate, $endDate, $categories, $products);
        $last_year_visitors = $this->getVistorsByOrders($last_startDate, $last_endDate, $categories, $products);

        $data_source['visitors'] = $this->getDataSource($this_year_visitors, $last_year_visitors, $filter_type, $startDate, $endDate);

        # this is the data source of the donut chart - filter by category
        $data_source['categories'] =  $this->getProfitByCategory($startDate, $endDate, $categories);
        # this is the data source of the report
        $this_year_per_product = $this->getReportData($startDate, $endDate, $categories, $products);
        $last_year_per_product = $this->getReportData($last_startDate, $last_endDate, $categories, $products);
        $data_source['report'] = [$this_year_per_product, $last_year_per_product];

        return $data_source;
    }

    public function mount() {
        $this->dataSource = $this->getDataSourceFromDB(FilterType::LastMonth);
    }

    private function getDataSource($this_year_data, $last_year_data, $filter_type, $start_date=null, $end_date=null): array {
        # fill blank
        $this_year_data = $this->fillBlank($this_year_data, $filter_type, 0, $start_date, $end_date);
        $last_year_data = $this->fillBlank($last_year_data, $filter_type, -1, $start_date, $end_date);

        # sort
        ksort($this_year_data);
        ksort($last_year_data);

        #summay for total
        $this_year_total = $this->getTotalSummary($this_year_data);
        $last_year_total = $this->getTotalSummary($last_year_data);

        return [
            'labels' => $this->getOnlyMonthDayFormat(array_keys($this_year_data)),
            'data' => [array_values($this_year_data), array_values($last_year_data)],
            'total' => [$this_year_total, $last_year_total]
        ];
    }

    public function render()
    {
        return view('livewire.pages.dashboard.chart-container');
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @return mixed
     */
    public function getTotalProfitByOrderItems(string $startDate, string $endDate, array $categories, array $products): mixed
    {
        return OrderItem::WhereBetween('created_at', [$startDate, $endDate])->whereHas('product', function ($p_query) use ($categories, $products) {
            if (count($categories) == 0 && count($products) == 0) {
                return $p_query;
            } else if (count($categories) > 0 && count($products) == 0) {
                return $p_query->whereIn('category_id', $categories);
            } else if (count($categories) == 0 && count($products) > 0) {
                return $p_query->whereIn('id', $products);
            } else {
                return $p_query->whereIn('category_id', $categories)->whereIn('id', $products);
            }
        })->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as created, Round(Sum(price*(1-discount/100)*quantity),2) as item_total')
            ->groupBy('created')
            ->orderBy('created', 'asc')
            ->get()
            ->pluck('item_total', 'created')
            ->toArray();
    }

    private function getImplodedData(array $data): string {
        return implode(",", $data);
    }

    /**
     * @param array dataSource
     * @return array
     */
    private function fillBlank(array $dataSource, FilterType $filterType, int $flag, $start_date=null, $end_date=null): array
    {
        $start = 0;
        $end = 0;
        switch ($filterType) {
            case FilterType::Today:
                break;
            case FilterType::Yesterday:
                $start = $end = 1;
                break;
            case FilterType::Last7Days:
                $end = 6;
                break;
            case FilterType::Last30Days:
                $end = 29;
                break;
            case FilterType::ThisMonth:
                $end = Carbon::now()->startOfMonth()->diffInDays(Carbon::now()) - 1;
                break;
            case FilterType::LastMonth:
                $start = Carbon::now()->subMonth(1)->endOfMonth()->diffInDays(Carbon::now()) + 1;
                $end = Carbon::now()->subMonth(1)->startOfMonth()->diffInDays(Carbon::now());
                break;
            case FilterType::Custom:
                $start = Carbon::now()->diffInDays($start_date);
                $end = Carbon::now()->diffInDays($end_date) + 1;
        }
        foreach (range($start, $end) as $index) {
            $date = $flag === 0 ? Carbon::now()->subDay($index)->format('Y-m-d') : Carbon::now()->subYear(1)->subDay($index)->format('Y-m-d');
            $dataSource[$date] = $dataSource[$date] ?? 0;
        }
        return $dataSource;
    }

    private function getOnlyMonthDayFormat(array $data_array): array
    {
        return array_map(function ($item) {
            return Carbon::parse($item)->format('M d');
        }, $data_array);
    }

    private function getVistorsByOrders(string $startDate, string $endDate, array $categories, array $products)
    {
        return OrderItem::whereBetween('created_at', [$startDate, $endDate])->whereHas('product', function ($p_query) use ($categories, $products) {
            if (count($categories) == 0 && count($products) == 0) {
                return $p_query;
            } else if (count($categories) > 0 && count($products) == 0) {
                return $p_query->whereIn('category_id', $categories);
            } else if (count($categories) == 0 && count($products) > 0) {
                return $p_query->whereIn('id', $products);
            } else {
                return $p_query->whereIn('category_id', $categories)->whereIn('id', $products);
            }
        })->with('owner')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as created, COUNT(*) as visitors')
            ->groupBy('created')
            ->orderBy('created', 'asc')
            ->get()
            ->pluck('visitors', 'created')
            ->toArray();
    }

    /**
     * @param $array
     * @return mixed
     */
    public function getTotalSummary($array): mixed
    {
        return array_reduce($array, function ($carry, $item) {
            return $carry + $item;
        });
    }

    private function getProfitByCategory(string $startDate, string $endDate, array $categories): array
    {
        return OrderItem::whereBetween('created_at', [$startDate, $endDate])->whereHas('product', function ($p_query) use ($categories) {
            if (count($categories) == 0) {
                return $p_query;
            } else {
                return $p_query->whereIn('category_id', $categories);
            }
        })
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as created, price*(1-discount/100)*quantity as item_total, product_id')
            ->with('category')
            ->get()
            ->groupBy('category.name')
            ->map(function ($item) {
                return round($item->sum('item_total'), 2);
            })->toArray();
    }

    private function getReportData(string $startDate, string $endDate, array $categories, array $products): array
    {
        return array_values(OrderItem::whereBetween('created_at', [$startDate, $endDate])->whereHas('product', function ($p_query) use ($categories, $products) {
            if (count($categories) == 0 && count($products) == 0) {
                return $p_query;
            } else if (count($categories) > 0 && count($products) == 0) {
                return $p_query->whereIn('category_id', $categories);
            } else if (count($categories) == 0 && count($products) > 0) {
                return $p_query->whereIn('id', $products);
            } else {
                return $p_query->whereIn('category_id', $categories)->whereIn('id', $products);
            }
        })->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as created, price*(1-discount/100)*quantity as item_sales, product_id, quantity')
            ->with('product')
            ->get()
            ->groupBy('product.name')->map(function ($item) {
                return [
                    'id' => $item->first()->product->id,
                    'name' => $item->first()->product->name,
                    'sales' => round($item->sum('item_sales'), 2),
                    'quantity' => $item->sum('quantity'),
                    'price' => $item->first()->product->price
                ];
            })->toArray());
    }
}
