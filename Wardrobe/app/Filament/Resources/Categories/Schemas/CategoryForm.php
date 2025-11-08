<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ColorPicker;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => 
                        $set('slug', Str::slug($state))
                    )
                    ->label('Category Title')
                    ->placeholder('e.g., Shirts, Dresses, Shoes')
                    ->helperText('Enter the name of the category')
                    ->columnSpan(1),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->label('URL Slug')
                    ->placeholder('auto-generated-from-title')
                    ->helperText('Auto-generated, but you can customize it')
                    ->columnSpan(1),

                Textarea::make('description')
                    ->rows(3)
                    ->maxLength(1000)
                    ->label('Description')
                    ->placeholder('Brief description of this category')
                    ->helperText('Describe what types of items belong in this category')
                    ->columnSpanFull(),

                FileUpload::make('image')
                    ->image()
                    ->directory('categories')
                    ->visibility('public')
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                        '4:3',
                        '1:1',
                    ])
                    ->maxSize(2048) // 2MB
                    ->label('Category Image')
                    ->helperText('Upload a representative image for this category (max 2MB)')
                    ->columnSpanFull(),

                Select::make('icon')
                    ->options([
                        'heroicon-o-user' => 'User',
                        'heroicon-o-sparkles' => 'Sparkles',
                        'heroicon-o-star' => 'Star',
                        'heroicon-o-heart' => 'Heart',
                        'heroicon-o-shopping-bag' => 'Shopping Bag',
                        'heroicon-o-gift' => 'Gift',
                        'heroicon-o-sun' => 'Sun',
                        'heroicon-o-moon' => 'Moon',
                        'heroicon-o-bolt' => 'Bolt',
                        'heroicon-o-fire' => 'Fire',
                        'heroicon-o-shield-check' => 'Shield',
                        'heroicon-o-squares-2x2' => 'Squares',
                        'heroicon-o-rectangle-stack' => 'Rectangle Stack',
                        'heroicon-o-cube' => 'Cube',
                        'heroicon-o-tag' => 'Tag',
                    ])
                    ->searchable()
                    ->label('Icon')
                    ->placeholder('Select an icon')
                    ->helperText('Choose an icon to represent this category')
                    ->columnSpan(1),

                ColorPicker::make('color')
                    ->label('Color')
                    ->placeholder('#3B82F6')
                    ->helperText('Choose a color for visual identification')
                    ->columnSpan(1),

                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->label('Sort Order')
                    ->placeholder('0')
                    ->helperText('Lower numbers appear first')
                    ->columnSpan(1),

                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true)
                    ->helperText('Inactive categories will be hidden from users')
                    ->inline(false)
                    ->columnSpan(1),
            ])
            ->columns(2);
    }
}
