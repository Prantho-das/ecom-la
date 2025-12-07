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
    public $showMode = "grid";


    public function changeShowMode($mode)
    {
        $this->showMode = $mode;
    }
    public function mount()
    {
        $this->categories = CategoryModel::where('is_active', 1)->get();
        if (request()->filled('category_slug')) {
            $this->category = CategoryModel::where('slug', request()->category_slug)->first();
        }
    }
    public function render()
    {
        $category_products = Product::with('images');
        if($this->category){
            $category_products= $category_products->whereHas(
                'categories',
                fn($q) =>
               $q->where('categories.id', $this->category->id) 
            );
        }



        $category_products = $category_products->get();
        dd($category_products);
        return view('livewire.frontend.category', [
            'category_products' => $category_products
        ]);
    }
}
