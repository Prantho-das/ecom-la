<?php

namespace App\Filament\DarkAdmin\Resources\ServiceCategories\Pages;

use App\Filament\DarkAdmin\Resources\ServiceCategories\ServiceCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateServiceCategory extends CreateRecord
{
    protected static string $resource = ServiceCategoryResource::class;
}
