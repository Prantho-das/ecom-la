<?php

namespace App\Livewire\Frontend;

use App\Models\ServiceCategory;
use Livewire\Component;

class ServiceCategoryShow extends Component
{
    public $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        $serviceCategory = ServiceCategory::where('slug', $this->slug)->where('published', true)->firstOrFail();

        return view('livewire.service-category-show', [
            'serviceCategory' => $serviceCategory,
        ])->layout('layouts.frontend');
    }
}
