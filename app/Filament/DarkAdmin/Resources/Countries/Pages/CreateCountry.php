<?php

namespace App\Filament\DarkAdmin\Resources\Countries\Pages;

use App\Filament\DarkAdmin\Resources\Countries\CountryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCountry extends CreateRecord
{
    protected static string $resource = CountryResource::class;
}
