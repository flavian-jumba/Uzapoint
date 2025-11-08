<?php

namespace App\Filament\Resources\Outfits\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;

class OutfitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Photo')
                    ->circular()
                    ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&color=8B5CF6&background=EDE9FE')
                    ->size(50),

                TextColumn::make('name')
                    ->label('Outfit Name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->name),

                TextColumn::make('user.name')
                    ->label('Owner')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('occasion')
                    ->label('Occasion')
                    ->badge()
                    ->color(fn (string $state = null): string => match ($state) {
                        'Casual' => 'success',
                        'Formal' => 'danger',
                        'Business' => 'primary',
                        'Party' => 'warning',
                        'Athletic' => 'info',
                        'Date Night' => 'fuchsia',
                        'Travel' => 'cyan',
                        'Wedding' => 'rose',
                        default => 'gray',
                    })
                    ->icon(fn (string $state = null): string => match ($state) {
                        'Casual' => 'heroicon-o-home',
                        'Formal' => 'heroicon-o-briefcase',
                        'Business' => 'heroicon-o-building-office',
                        'Party' => 'heroicon-o-cake',
                        'Athletic' => 'heroicon-o-bolt',
                        'Date Night' => 'heroicon-o-heart',
                        'Travel' => 'heroicon-o-globe-alt',
                        'Wedding' => 'heroicon-o-sparkles',
                        default => 'heroicon-o-tag',
                    })
                    ->sortable()
                    ->searchable(),

                TextColumn::make('season')
                    ->label('Season')
                    ->badge()
                    ->color(fn (string $state = null): string => match ($state) {
                        'Spring' => 'success',
                        'Summer' => 'warning',
                        'Fall' => 'danger',
                        'Winter' => 'info',
                        'All Season' => 'gray',
                        default => 'gray',
                    })
                    ->icon(fn (string $state = null): string => match ($state) {
                        'Spring' => 'heroicon-o-sparkles',
                        'Summer' => 'heroicon-o-sun',
                        'Fall' => 'heroicon-o-arrow-trending-down',
                        'Winter' => 'heroicon-o-cloud',
                        'All Season' => 'heroicon-o-calendar',
                        default => 'heroicon-o-question-mark-circle',
                    })
                    ->sortable(),

                TextColumn::make('clothingItems_count')
                    ->label('Items')
                    ->counts('clothingItems')
                    ->badge()
                    ->color('primary')
                    ->alignCenter()
                    ->sortable(),

                TextColumn::make('description')
                    ->label('Description')
                    ->limit(40)
                    ->tooltip(fn ($record) => $record->description)
                    ->wrap()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('user_id')
                    ->label('Owner')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('occasion')
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
                    ->multiple(),

                SelectFilter::make('season')
                    ->label('Season')
                    ->options([
                        'Spring' => 'Spring',
                        'Summer' => 'Summer',
                        'Fall' => 'Fall',
                        'Winter' => 'Winter',
                        'All Season' => 'All Season',
                    ])
                    ->multiple(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s')
            ->striped()
            ->emptyStateHeading('No outfits yet')
            ->emptyStateDescription('Create your first outfit by combining clothing items.')
            ->emptyStateIcon('heroicon-o-squares-2x2');
    }
}