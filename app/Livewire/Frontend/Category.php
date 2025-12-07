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
    public $category_products=[];
    public function mount(){
        if(request()->filled('category_slug')){
            $this->category=CategoryModel::where('slug',request()->category_slug)->first();
        }
        $this->category_products = Product::with(['images'])
            ->whereHas('categories', function ($q) {
                if($this->category){
                    $q->whereIn('categories.id', $this->category->id);
                }
            })->paginate();
    }
    public function render()
    {
        return view('livewire.frontend.category');
    }
}
