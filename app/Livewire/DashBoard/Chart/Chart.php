<?php

namespace App\Livewire\DashBoard\Chart;

use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class Chart extends Component
{
    public string $type;

    #[Reactive]
    public array $datasource;

    public function render()
    {
        Log::info('Chart render');
        return view('livewire.pages.dashboard.chart');
    }
}
