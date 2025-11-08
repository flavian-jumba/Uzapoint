<?php

namespace App\Filament\Resources\ClothingItems;

use App\Filament\Resources\ClothingItems\Pages\CreateClothingItem;
use App\Filament\Resources\ClothingItems\Pages\EditClothingItem;
use App\Filament\Resources\ClothingItems\Pages\ListClothingItems;
use App\Filament\Resources\ClothingItems\Schemas\ClothingItemForm;
use App\Filament\Resources\ClothingItems\Tables\ClothingItemsTable;
use App\Models\ClothingItem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ClothingItemResource extends Resource
{
    protected static ?string $model = ClothingItem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingBag;

    protected static ?string $navigationLabel = 'Clothing Items';

    protected static ?string $modelLabel = 'Clothing Item';

    protected static ?string $pluralModelLabel = 'Clothing Items';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return ClothingItemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClothingItemsTable::configure($table);
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
            'index' => ListClothingItems::route('/'),
            'create' => CreateClothingItem::route('/create'),
            'edit' => EditClothingItem::route('/{record}/edit'),
        ];
    }
}
