<?php

namespace App\Filament\DarkAdmin\Resources\Solutions;

use App\Filament\DarkAdmin\Resources\Solutions\Pages\CreateSolution;
use App\Filament\DarkAdmin\Resources\Solutions\Pages\EditSolution;
use App\Filament\DarkAdmin\Resources\Solutions\Pages\ListSolutions;
use App\Filament\DarkAdmin\Resources\Solutions\Schemas\SolutionForm;
use App\Filament\DarkAdmin\Resources\Solutions\Tables\SolutionsTable;
use App\Models\Solution;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class SolutionResource extends Resource
{
    protected static ?string $model = Solution::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-puzzle-piece';

    protected static string|\UnitEnum|null $navigationGroup = 'Product Catalog';

    protected static ?int $navigationSort = 6;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return SolutionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SolutionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSolutions::route('/'),
            'create' => CreateSolution::route('/create'),
            'edit' => EditSolution::route('/{record}/edit'),
        ];
    }
}
