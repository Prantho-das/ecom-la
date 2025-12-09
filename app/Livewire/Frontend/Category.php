<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category as ModelCategory;
use Livewire\WithPagination;

class Category extends Component
{
    use WithPagination;

    public $category_slug;
    public $category;
    public $categories;
    public $showMode = 'grid';

    protected $queryString = ['category_slug'];  // Sync with URL

    public function mount($category_slug = null)
    {
        $this->categories = ModelCategory::where('is_active', 1)->get();

        if ($category_slug) {
            $this->category = ModelCategory::where('slug', $category_slug)->first();
        }
    }

    // Reset pagination when category_slug changes
    public function updatingCategorySlug()
    {
        $this->resetPage();
    }

    public function changeShowMode($mode)
    {
        $this->showMode = $mode;
    }

    public function render()
    {
        $category_products = Product::with('images');

        if ($this->category) {
            $category_products = $category_products->whereHas('categories', function ($q) {
                $q->where('categories.id', $this->category->id);
            });
        }

        $category_products = $category_products->simplePaginate(10);

        return view('livewire.frontend.category', [
            'category_products' => $category_products,
        ]);
    }
}
