<?php

namespace App\Livewire\Frontend;

use App\Models\ServiceCategory;
use Livewire\Component;

class ServiceCategoryIndex extends Component
{
    public function render()
    {
        $serviceCategories = ServiceCategory::where('published', true)->get();

        return view('livewire.service-category-index', [
            'serviceCategories' => $serviceCategories,
        ])->layout('layouts.frontend');
    }
}
