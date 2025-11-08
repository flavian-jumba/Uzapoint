<?php

namespace App\Filament\Resources\ClothingItems\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\ColorPicker;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\User;

class ClothingItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Basic Information
                Select::make('user_id')
                    ->label('Owner')
                    ->options(User::pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->default(fn () => Auth::id())
                    ->helperText('Select the owner of this clothing item')
                    ->columnSpan(1),

                Select::make('category_id')
                    ->label('Category')
                    ->options(Category::where('is_active', true)->pluck('title', 'id'))
                    ->searchable()
                    ->required()
                    ->preload()
                    ->helperText('Choose the category for this item')
                    ->columnSpan(1),

                TextInput::make('name')
                    ->label('Item Name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g., Blue Denim Jacket')
                    ->helperText('Give this item a descriptive name')
                    ->columnSpanFull(),

                Textarea::make('description')
                    ->label('Description')
                    ->rows(3)
                    ->maxLength(1000)
                    ->placeholder('Describe the item, its features, or when you wear it...')
                    ->helperText('Optional details about this clothing item')
                    ->columnSpanFull(),

                FileUpload::make('image')
                    ->label('Item Photo')
                    ->image()
                    ->directory('clothing-items')
                    ->visibility('public')
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '1:1',
                        '4:5',
                        '16:9',
                    ])
                    ->maxSize(3072) // 3MB
                    ->helperText('Upload a photo of the clothing item (max 3MB)')
                    ->columnSpanFull(),

                // Item Details
                TextInput::make('brand')
                    ->label('Brand')
                    ->maxLength(255)
                    ->placeholder('e.g., Zara, H&M, Nike')
                    ->helperText('Brand or manufacturer')
                    ->columnSpan(1),

                ColorPicker::make('color')
                    ->label('Primary Color')
                    ->helperText('Main color of the item')
                    ->columnSpan(1),

                Select::make('size')
                    ->label('Size')
                    ->options([
                        'XXS' => 'XXS',
                        'XS' => 'XS',
                        'S' => 'S',
                        'M' => 'M',
                        'L' => 'L',
                        'XL' => 'XL',
                        'XXL' => 'XXL',
                        'XXXL' => 'XXXL',
                        'One Size' => 'One Size',
                    ])
                    ->searchable()
                    ->placeholder('Select size')
                    ->helperText('Clothing size')
                    ->columnSpan(1),

                TextInput::make('price')
                    ->label('Price')
                    ->numeric()
                    ->prefix('$')
                    ->minValue(0)
                    ->step(0.01)
                    ->placeholder('0.00')
                    ->helperText('Purchase price (optional)')
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
                    ->helperText('Best season to wear this item')
                    ->columnSpan(1),

                Select::make('condition')
                    ->label('Condition')
                    ->options([
                        'New' => 'New (with tags)',
                        'Like New' => 'Like New',
                        'Good' => 'Good',
                        'Fair' => 'Fair',
                        'Worn' => 'Worn',
                    ])
                    ->placeholder('Select condition')
                    ->default('Good')
                    ->helperText('Current condition of the item')
                    ->columnSpan(1),

                DatePicker::make('purchase_date')
                    ->label('Purchase Date')
                    ->placeholder('Select date')
                    ->maxDate(now())
                    ->helperText('When did you purchase this item?')
                    ->columnSpan(1),

                Toggle::make('is_favorite')
                    ->label('Mark as Favorite')
                    ->default(false)
                    ->helperText('Add to your favorites collection')
                    ->inline(false)
                    ->columnSpan(1),
            ])
            ->columns(2);
    }
}