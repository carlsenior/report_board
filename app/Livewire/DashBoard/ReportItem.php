<?php

namespace App\Livewire\DashBoard;

use Livewire\Component;

class ReportItem extends Component
{

    public array $this_data;
    public array $last_data;

    public function render()
    {
        return view('livewire.pages.dashboard.report-item');
    }
}
