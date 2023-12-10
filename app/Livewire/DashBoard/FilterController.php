<?php

namespace App\Livewire\DashBoard;

use App\Models\Category;
use Livewire\Attributes\On;
use Livewire\Component;

class FilterController extends Component
{
    public array $categories = [];

    public function mount() {
        $this->categories = Category::with('products')->get()->toArray();
    }


    public function render()
    {
        return view('livewire.pages.dashboard.filter-controller')->with([
            'categories' => $this->categories,
        ]);
    }
}
