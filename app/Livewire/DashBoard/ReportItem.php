<?php

namespace App\Livewire\DashBoard;

use Livewire\Component;

class ReportItem extends Component
{

    public object $this_data;
    public object $last_data;

    public function render()
    {
        return view('livewire.pages.dashboard.report-item');
    }
}
