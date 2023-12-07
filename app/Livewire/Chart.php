<?php

namespace App\Livewire;

use Livewire\Component;

class Chart extends Component
{
    public string $type;

    public function render()
    {
        return view('livewire.chart');
    }
}
