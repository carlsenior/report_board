<?php

namespace App\Livewire\DashBoard\Chart;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Livewire\Component;

class ChartContainer extends Component
{
    private FilterType $filterType = FilterType::LAST30DAYS;
    public array $dataSource = [];

    public function mount() {

        # initial end date is today
        $endDate = Carbon::now()->format('Y-m-d');
        $last_endDate = Carbon::now()->subYear(1)->format('Y-m-d');
        # initial start date is 29 days ago
        $startDate = Carbon::now()->subDay(29)->format('Y-m-d');
        $last_startDate = Carbon::now()->subYear(1)->subDay(29)->format('Y-m-d');

        # this is the data source of the barchart - sales
        $this_year_profit = $this->getTotalProfitByOrderItems($startDate, $endDate);
        $last_year_profit = $this->getTotalProfitByOrderItems($last_startDate, $last_endDate);

        $this->dataSource['sales'] = $this->getDataSource($this_year_profit, $last_year_profit);

        # this is the data source of the area chart - visitors
        $this_year_visitors = $this->getVistorsByOrders($startDate, $endDate);
        $last_year_visitors = $this->getVistorsByOrders($last_startDate, $last_endDate);

        $this->dataSource['visitors'] = $this->getDataSource($this_year_visitors, $last_year_visitors);

        # this is the data source of the donut chart - filter by category

//        dd($this_year_profit);
    }

    private function getDataSource($this_year_data, $last_year_data): array {
        # fill blank
        $this_year_data = $this->fillBlank($this_year_data, $this->filterType, 0);
        $last_year_data = $this->fillBlank($last_year_data, $this->filterType, -1);

        # sort
        ksort($this_year_data);
        ksort($last_year_data);

        #summay
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
        return view('livewire.pages.dashboard.chart-container')->with([
            'dataSource' => $this->dataSource
        ]);
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @return mixed
     */
    public function getTotalProfitByOrderItems(string $startDate, string $endDate): array
    {
        return OrderItem::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('id, product_id, order_id, DATE_FORMAT(created_at, "%Y-%m-%d") as created, quantity * price * (100-discount)/100 as order_item_total_price')
            ->orderBy('created')
            ->get()
            ->groupBy('created')
            ->map(function ($items) {
                return round($items->sum('order_item_total_price'), 2);
            })
            ->toArray();
    }

    /**
     * @param array dataSource
     * @return array
     */
    private function fillBlank(array $dataSource, FilterType $filterType, int $flag): array
    {
        $start = 0;
        $end = 0;
        switch ($filterType) {
            case FilterType::TODAY:
                break;
            case FilterType::YESTERDAY:
                $start = $end = 1;
                break;
            case FilterType::LAST7DAYS:
                $end = 6;
                break;
            case FilterType::LAST30DAYS:
                $end = 29;
                break;
            case FilterType::THIS_MONTH:
                $end = Carbon::now()->startOfMonth()->diffInDays(Carbon::now()) - 1;
                break;
            case FilterType::LAST_MONTH:
                $end = 1;
                break;
            case FilterType::CUSTOM:
                $end = 1;
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

    private function getVistorsByOrders(string $startDate, string $endDate)
    {
         return Order::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('customer_id, DATE_FORMAT(created_at, "%Y-%m-%d") as created, 1 as count')
            ->orderBy('created')
            ->with('owner')
            ->get()
            ->groupBy('created')
            ->map(function ($items) {
                return $items->sum('count');
            })
            ->toarray();
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
}
