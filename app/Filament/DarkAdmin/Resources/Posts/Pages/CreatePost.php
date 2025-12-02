<?php

namespace App\Filament\DarkAdmin\Resources\Posts\Pages;

use App\Filament\DarkAdmin\Resources\Posts\PostResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;
}
