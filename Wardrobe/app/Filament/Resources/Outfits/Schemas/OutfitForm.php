<?php

namespace App\Filament\Resources\Outfits\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\CheckboxList;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ClothingItem;

class OutfitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Owner')
                    ->options(User::pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->default(fn () => Auth::id())
                    ->helperText('Select the owner of this outfit')
                    ->columnSpan(1),

                TextInput::make('name')
                    ->label('Outfit Name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g., Summer Beach Casual, Office Meeting')
                    ->helperText('Give this outfit a descriptive name')
                    ->columnSpan(1),

                Textarea::make('description')
                    ->label('Description')
                    ->rows(3)
                    ->maxLength(1000)
                    ->placeholder('Describe the outfit, when to wear it, styling notes...')
                    ->helperText('Optional details about this outfit')
                    ->columnSpanFull(),

                FileUpload::make('image')
                    ->label('Outfit Photo')
                    ->image()
                    ->directory('outfits')
                    ->visibility('public')
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '1:1',
                        '4:5',
                        '9:16',
                    ])
                    ->maxSize(3072) // 3MB
                    ->helperText('Upload a photo of the complete outfit (max 3MB)')
                    ->columnSpanFull(),

                Select::make('occasion')
                    ->label('Occasion')
                    ->options([
                        'Casual' => 'Casual',
                        'Formal' => 'Formal',
                        'Business' => 'Business',
                        'Party' => 'Party',
                        'Athletic' => 'Athletic',
                        'Date Night' => 'Date Night',
                        'Travel' => 'Travel',
                        'Wedding' => 'Wedding',
                    ])
                    ->searchable()
                    ->placeholder('Select occasion')
                    ->helperText('When would you wear this outfit?')
                    ->columnSpan(1),

                Select::make('season')
                    ->label('Season')
                    ->options([
                        'Spring' => 'Spring',
                        'Summer' => 'Summer',
                        'Fall' => 'Fall',
                        'Winter' => 'Winter',
                        'All Season' => 'All Season',
                    ])
                    ->placeholder('Select season')
                    ->helperText('Best season for this outfit')
                    ->columnSpan(1),

                CheckboxList::make('clothingItems')
                    ->label('Clothing Items')
                    ->relationship('clothingItems', 'name')
                    ->options(function () {
                        return ClothingItem::with('category')
                            ->get()
                            ->groupBy('category.title')
                            ->map(fn ($items) => $items->pluck('name', 'id'))
                            ->toArray();
                    })
                    ->searchable()
                    ->bulkToggleable()
                    ->columns(3)
                    ->helperText('Select the clothing items that make up this outfit')
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}