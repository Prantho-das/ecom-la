<?php

namespace App\Filament\DarkAdmin\Resources\Posts\Schemas;

use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                FileUpload::make('thumbnail')
                    ->image()
                    ->disk('public')
                    ->directory('thumbnails')
                    ->nullable(),
                RichEditor::make('content')
                    ->columnSpanFull()
                    ->nullable(),
                DateTimePicker::make('published_at')
                    ->nullable(),
                Select::make('user_id')
                    ->label('Author')
                    ->options(User::pluck('name', 'id'))
                    ->searchable()
                    ->required(),
            ]);
    }
}
