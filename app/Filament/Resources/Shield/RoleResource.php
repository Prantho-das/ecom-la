<?php

namespace App\Filament\Resources\Shield;

use App\Filament\Resources\Shield\Pages\ManageRoles;
use BackedEnum;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationLabel = 'Roles';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';

    protected static string|\UnitEnum|null $navigationGroup = 'System Settings';

    protected static ?int $navigationSort = 2;

    public static function getGroupedPermissions(): array
    {
        $permissions = Permission::all();
        $flatPermissions = [];

        $resourcePrefixes = [
            'view_any', 'view', 'create', 'update',
            'delete_any', 'delete',
            'force_delete_any', 'force_delete',
            'restore', 'replicate', 'reorder',
        ];

        $actionLabels = [
            'view_any' => 'View Any',
            'view' => 'View',
            'create' => 'Create',
            'update' => 'Update',
            'delete_any' => 'Delete Any',
            'delete' => 'Delete',
            'force_delete_any' => 'Force Delete Any',
            'force_delete' => 'Force Delete',
            'restore' => 'Restore',
            'replicate' => 'Replicate',
            'reorder' => 'Reorder',
        ];

        foreach ($permissions as $permission) {
            $name = $permission->name;

            if (str_starts_with($name, 'page_')) {
                $pageName = substr($name, 5);
                $flatPermissions[$permission->id] = "Pages: {$pageName}";
                continue;
            }

            if (str_starts_with($name, 'widget_')) {
                $widgetName = substr($name, 7);
                $flatPermissions[$permission->id] = "Widgets: {$widgetName}";
                continue;
            }

            $matched = false;
            foreach ($resourcePrefixes as $prefix) {
                $prefixLen = strlen($prefix) + 1;
                if (str_starts_with($name, $prefix . '_')) {
                    $resource = substr($name, $prefixLen);
                    $resourceName = str($resource)->title()->toString();
                    $action = $actionLabels[$prefix] ?? $prefix;
                    $flatPermissions[$permission->id] = "{$resourceName}: {$action}";
                    $matched = true;
                    break;
                }
            }

            if (!$matched) {
                $flatPermissions[$permission->id] = "Other: {$name}";
            }
        }

        asort($flatPermissions);

        return $flatPermissions;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                Hidden::make('guard_name')
                    ->default('web')
                    ->dehydrateStateUsing(fn () => 'web'),

                CheckboxList::make('permissions')
                    ->label('Permissions')
                    ->options(fn () => static::getGroupedPermissions())
                    ->searchable()
                    ->bulkToggleable()
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('permissions_count')
                    ->label('Permissions')
                    ->counts('permissions'),
                TextColumn::make('guard_name'),
                TextColumn::make('created_at')->date()->sortable(),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['guard_name'] = 'web';
                        return $data;
                    })
                    ->after(function ($record, array $data) {
                        if (isset($data['permissions'])) {
                            $record->syncPermissions($data['permissions']);
                        }
                    }),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageRoles::route('/'),
        ];
    }
}
