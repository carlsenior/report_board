<?php

namespace App\Livewire\DashBoard\Chart;

use App\Models\OrderItem;
use Carbon\Carbon;
use Livewire\Component;

class ChartContainer extends Component
{
    private FilterType $filterType = FilterType::LAST30DAYS;
    public array $labels;
    public array $data;

    public function mount() {
        # initial end date is today
        $endDate = Carbon::now()->format('Y-m-d');
        # initial start date is 29 days ago
        $startDate = Carbon::now()->subDay(29)->format('Y-m-d');
        # this is the data source of the chart
        $dataSource = OrderItem::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('id, product_id, order_id, DATE_FORMAT(created_at, "%Y-%m-%d") as created, quantity * price * (100-discount)/100 as order_item_total_price')
            ->get()
            ->groupBy('created')
            ->map(function ($items) {
                return $items->sum('order_item_total_price');
            })
            ->toArray();
        foreach (range(0, 29) as $index) {
            $date = Carbon::now()->subDay($index)->format('Y-m-d');
            $dataSource[$date] = $this->dataSource[$date] ?? 0;
        }
        $this->labels = array_keys($dataSource);
        $this->data = array_values($dataSource);
    }

    public function render()
    {
        return view('livewire.pages.dashboard.chart-container')->with([
            'labels' => $this->labels,
            'data' => $this->data
        ]);
    }
}
