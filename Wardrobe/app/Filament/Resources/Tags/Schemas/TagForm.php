<?php

namespace App\Filament\Resources\Tags\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Illuminate\Support\Str;

class TagForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Tag Name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => 
                        $set('slug', Str::slug($state))
                    )
                    ->placeholder('e.g., casual, formal, vintage')
                    ->helperText('Enter a descriptive tag name (must be unique)')
                    ->columnSpan(1),

                TextInput::make('slug')
                    ->label('Slug')
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->placeholder('auto-generated-slug')
                    ->helperText('URL-friendly version (auto-generated)')
                    ->columnSpan(1),

                Textarea::make('description')
                    ->label('Description')
                    ->rows(2)
                    ->maxLength(500)
                    ->placeholder('Optional description of what this tag represents...')
                    ->helperText('Optional: Describe when to use this tag')
                    ->columnSpanFull(),

                ColorPicker::make('color')
                    ->label('Tag Color')
                    ->placeholder('#3B82F6')
                    ->helperText('Choose a color for this tag badge')
                    ->columnSpan(1),

                Select::make('icon')
                    ->label('Icon')
                    ->options([
                        'heroicon-o-tag' => 'Tag',
                        'heroicon-o-star' => 'Star',
                        'heroicon-o-sparkles' => 'Sparkles',
                        'heroicon-o-heart' => 'Heart',
                        'heroicon-o-fire' => 'Fire',
                        'heroicon-o-bolt' => 'Bolt',
                        'heroicon-o-sun' => 'Sun',
                        'heroicon-o-moon' => 'Moon',
                        'heroicon-o-cloud' => 'Cloud',
                        'heroicon-o-gift' => 'Gift',
                        'heroicon-o-clock' => 'Clock',
                        'heroicon-o-calendar' => 'Calendar',
                    ])
                    ->searchable()
                    ->placeholder('Select an icon')
                    ->helperText('Optional icon for the tag')
                    ->columnSpan(1),
            ])
            ->columns(2);
    }
}