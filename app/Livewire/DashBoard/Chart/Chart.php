<?php

namespace App\Livewire\DashBoard\Chart;

use Livewire\Component;

class Chart extends Component
{
    public string $type;
    public array $labels;
    public array $data;

    public function render()
    {
        return view('livewire.pages.dashboard.chart');
    }
}
