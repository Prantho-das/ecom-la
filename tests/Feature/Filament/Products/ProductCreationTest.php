<?php

use App\Filament\DarkAdmin\Resources\Products\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Filament\Facades\Filament;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    // Set the Filament panel for the tests
    Filament::setCurrentPanel(Filament::getPanel('dark-admin'));
});

it('can create a product with categories and correct status', function () {
    // 1. Act as an authenticated user (admin)
    $user = User::factory()->create();
    actingAs($user);

    // Create a brand for the product
    $brand = Brand::factory()->create();

    // Define product data, including categories as strings and is_active
    $productData = [
        'name' => 'Test Product',
        'slug' => 'test-product',
        'brand_id' => $brand->id,
        'short_description' => 'A short description.',
        'description' => 'A longer description for the test product.',
        'is_active' => true, // This will be converted to 'active' status
        'categories' => ['Electronics', 'Gadgets'], // TagsInput format
    ];

    // Simulate the Filament Livewire component for product creation
    Livewire::test(\App\Filament\DarkAdmin\Resources\Products\Pages\CreateProduct::class)
        ->fillForm($productData)
        ->call('create')
        ->assertHasNoFormErrors();

    // Assert that the product was created in the database
    $product = Product::where('slug', 'test-product')->first();
    expect($product)->not->toBeNull();
    expect($product->name)->toBe('Test Product');
    expect($product->brand_id)->toBe($brand->id);
    expect($product->status)->toBe('active'); // Assert correct status conversion

    // Assert that categories were created/found and associated
    $category1 = Category::where('name', 'Electronics')->first();
    $category2 = Category::where('name', 'Gadgets')->first();

    expect($category1)->not->toBeNull();
    expect($category2)->not->toBeNull();

    expect($product->categories->pluck('id')->toArray())
        ->toContain($category1->id, $category2->id);

    // Assert that the 'tags' JSON column is not populated with category names
    if (Schema::hasColumn('products', 'tags')) {
        expect($product->tags)->toBeNull();
    }
});

it('can create a product with existing categories', function () {
    $user = User::factory()->create();
    actingAs($user);

    $brand = Brand::factory()->create();
    $existingCategory = Category::factory()->create(['name' => 'Existing Category']);

    $productData = [
        'name' => 'Another Product',
        'slug' => 'another-product',
        'brand_id' => $brand->id,
        'short_description' => 'Another short description.',
        'description' => 'Another longer description.',
        'is_active' => false, // This will be converted to 'draft' status
        'categories' => ['Existing Category', 'New Category'],
    ];

    Livewire::test(\App\Filament\DarkAdmin\Resources\Products\Pages\CreateProduct::class)
        ->fillForm($productData)
        ->call('create')
        ->assertHasNoFormErrors();

    $product = Product::where('slug', 'another-product')->first();
    expect($product)->not->toBeNull();
    expect($product->status)->toBe('draft');

    $newCategory = Category::where('name', 'New Category')->first();
    expect($newCategory)->not->toBeNull();

    expect($product->categories->pluck('id')->toArray())
        ->toContain($existingCategory->id, $newCategory->id);
});

it('shows validation errors for invalid product data', function () {
    $user = User::factory()->create();
    actingAs($user);

    // Missing required fields
    $invalidProductData = [
        'name' => '', // Missing name
        'slug' => '', // Missing slug
        'brand_id' => null, // Missing brand
        'is_active' => true,
        'categories' => ['Test'],
    ];

    Livewire::test(\App\Filament\DarkAdmin\Resources\Products\Pages\CreateProduct::class)
        ->fillForm($invalidProductData)
        ->call('create')
        ->assertHasFormErrors(['name', 'slug', 'brand_id']);
});