<?php

namespace App\Livewire\DashBoard\Chart;

use Livewire\Component;

class Chart extends Component
{
    public string $type;

    public array $datasource;

    public function render()
    {
        return view('livewire.pages.dashboard.chart');
    }
}
