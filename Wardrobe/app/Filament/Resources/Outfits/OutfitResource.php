<?php

namespace App\Filament\Resources\Outfits;

use App\Filament\Resources\Outfits\Pages\CreateOutfit;
use App\Filament\Resources\Outfits\Pages\EditOutfit;
use App\Filament\Resources\Outfits\Pages\ListOutfits;
use App\Filament\Resources\Outfits\Schemas\OutfitForm;
use App\Filament\Resources\Outfits\Tables\OutfitsTable;
use App\Models\Outfit;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OutfitResource extends Resource
{
    protected static ?string $model = Outfit::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    protected static ?string $navigationLabel = 'Outfits';

    protected static ?string $modelLabel = 'Outfit';

    protected static ?string $pluralModelLabel = 'Outfits';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return OutfitForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OutfitsTable::configure($table);
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
            'index' => ListOutfits::route('/'),
            'create' => CreateOutfit::route('/create'),
            'edit' => EditOutfit::route('/{record}/edit'),
        ];
    }
}
