<?php

namespace App\Livewire\Frontend;

use App\Models\Service;
use App\Models\ServiceCategory;
use Livewire\Component;

class ServiceCategoryIndex extends Component
{
    public function render()
    {
        $serviceCategories = Service::where('published', true)
            ->when(request()->filled('category_id'), function ($query) {
                $query->whereHas('categories', function ($q) {
                    $q->where('service_service_category.service_category_id', request()->category_id);
                });
            })->get();

        return view('livewire.service-category-index', [
            'serviceCategories' => $serviceCategories,
        ])->layout('layouts.frontend');
    }
}
