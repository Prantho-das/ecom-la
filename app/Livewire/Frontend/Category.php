<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category as CategoryModel;
use Livewire\WithPagination;

class Category extends Component
{
    use WithPagination;
    public $category;
    public $categories;
    public $category_products = [];
    public $showMode="grid";
    
    public function mount()
    {
        $this->categories = CategoryModel::where('is_active',1)->get();
        if (request()->filled('category_slug')) {
            $this->category = CategoryModel::where('slug', request()->category_slug)->first();
        }
    }
    public function render()
    {
        $category_products = Product::with('images')
            ->whereHas(
                'categories',
                fn($q) =>
                $this->category ? $q->where('categories.id', $this->category->id) : null
            )
            ->simplePaginate();
        return view('livewire.frontend.category', compact('category_products'));
    }
}
