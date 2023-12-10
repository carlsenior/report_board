<?php

namespace App\Livewire\DashBoard\Chart;

use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\Reactive;
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
