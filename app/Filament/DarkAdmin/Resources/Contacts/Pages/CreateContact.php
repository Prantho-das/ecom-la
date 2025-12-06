<?php

namespace App\Filament\DarkAdmin\Resources\Contacts\Pages;

use App\Filament\DarkAdmin\Resources\Contacts\ContactResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContact extends CreateRecord
{
    protected static string $resource = ContactResource::class;
}
