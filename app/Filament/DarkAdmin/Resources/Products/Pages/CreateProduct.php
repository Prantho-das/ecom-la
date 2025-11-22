<?php

namespace App\Filament\DarkAdmin\Resources\Products\Pages;

use App\Filament\DarkAdmin\Resources\Products\ProductResource;
use App\Models\Category;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        // Unset categories to prevent error, as it's handled in afterCreate
        unset($data['categories']);

        return $data;
    }

    protected function afterCreate(): void
    {
        /** @var \App\Models\Product $product */
        $product = $this->getRecord();

        // Handle categories from TagsInput
        $categoriesFromForm = $this->data['categories'] ?? [];
        $categoryIds = [];
// dd($categoriesFromForm);
//         foreach ($categoriesFromForm as $categoryName) {
//             $category = Category::firstOrCreate(['name' => $categoryName]);
//             $categoryIds[] = $category->id;
//         }

        $product->categories()->sync($categoriesFromForm);
    }
}
