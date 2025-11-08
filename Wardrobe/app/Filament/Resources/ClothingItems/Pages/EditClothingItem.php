<?php

namespace App\Filament\Resources\ClothingItems\Pages;

use App\Filament\Resources\ClothingItems\ClothingItemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditClothingItem extends EditRecord
{
    protected static string $resource = ClothingItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
