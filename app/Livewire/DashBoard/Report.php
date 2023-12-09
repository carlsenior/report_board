<?php

namespace App\Livewire\DashBoard;

use Livewire\Component;

class Report extends Component
{
    public array $datasource;

    public function render()
    {
        return view('livewire.pages.dashboard.report');
    }
}
