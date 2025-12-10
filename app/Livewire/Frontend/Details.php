<?php

namespace App\Livewire\Frontend;

use App\Models\Product;
use Livewire\Component;

class Details extends Component
{
    public $product;

    public $quantity = 1;

    public $selectedVariant;

    public $relatedProducts = [];

    public $categories;

    public $images = [];

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function render()
    {
        // Load required relations
        $this->product->load(['images', 'categories']);

        // Product images
        $this->images = $this->product->images
            ->pluck('image_path')
            ->push($this->product->thumbnail)
            ->toArray();

        // Categories
        $this->categories = $this->product->categories;

        // Get related product IDs (other products sharing same categories)
        $relatedCategoryIds = $this->categories->pluck('id');

        $this->relatedProducts = Product::with(['images'])
            ->whereHas('categories', function ($q) use ($relatedCategoryIds) {
                $q->whereIn('categories.id', $relatedCategoryIds);
            })
            ->where('id', '!=', $this->product->id)
            ->limit(12) // optional: avoid loading huge list
            ->get();

        $this->dispatch('initSwipers');

        return view('livewire.frontend.details')->layout('layouts.frontend');
    }
}
