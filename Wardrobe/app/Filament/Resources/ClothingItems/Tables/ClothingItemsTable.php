<?php

namespace App\Filament\Resources\ClothingItems\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;

class ClothingItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Photo')
                    ->circular()
                    ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&color=FF6B6B&background=FFE5E5')
                    ->size(50),

                TextColumn::make('name')
                    ->label('Item Name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->name),

                TextColumn::make('category.title')
                    ->label('Category')
                    ->badge()
                    ->color(fn ($record) => $record->category?->color ?? 'gray')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label('Owner')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('brand')
                    ->label('Brand')
                    ->searchable()
                    ->sortable()
                    ->placeholder('N/A')
                    ->toggleable(),

                ColorColumn::make('color')
                    ->label('Color')
                    ->copyable()
                    ->toggleable(),

                TextColumn::make('size')
                    ->label('Size')
                    ->badge()
                    ->color('info')
                    ->alignCenter()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('price')
                    ->label('Price')
                    ->money('USD')
                    ->sortable()
                    ->placeholder('N/A')
                    ->toggleable(),

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
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('condition')
                    ->label('Condition')
                    ->badge()
                    ->color(fn (string $state = null): string => match ($state) {
                        'New' => 'success',
                        'Like New' => 'info',
                        'Good' => 'primary',
                        'Fair' => 'warning',
                        'Worn' => 'danger',
                        default => 'gray',
                    })
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('is_favorite')
                    ->label('Favorite')
                    ->boolean()
                    ->trueIcon('heroicon-o-heart')
                    ->falseIcon('heroicon-o-heart')
                    ->trueColor('danger')
                    ->falseColor('gray')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('tags_count')
                    ->label('Tags')
                    ->counts('tags')
                    ->badge()
                    ->color('primary')
                    ->alignCenter()
                    ->toggleable(),

                TextColumn::make('outfits_count')
                    ->label('Outfits')
                    ->counts('outfits')
                    ->badge()
                    ->color('success')
                    ->alignCenter()
                    ->toggleable(),

                TextColumn::make('purchase_date')
                    ->label('Purchased')
                    ->date('M d, Y')
                    ->sortable()
                    ->placeholder('N/A')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Added')
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
                SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'title')
                    ->searchable()
                    ->preload()
                    ->multiple(),

                SelectFilter::make('user_id')
                    ->label('Owner')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),

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

                SelectFilter::make('condition')
                    ->label('Condition')
                    ->options([
                        'New' => 'New',
                        'Like New' => 'Like New',
                        'Good' => 'Good',
                        'Fair' => 'Fair',
                        'Worn' => 'Worn',
                    ])
                    ->multiple(),

                SelectFilter::make('size')
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
                    ])
                    ->multiple(),

                TernaryFilter::make('is_favorite')
                    ->label('Favorites')
                    ->placeholder('All items')
                    ->trueLabel('Favorites only')
                    ->falseLabel('Non-favorites')
                    ->native(false),
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
            ->emptyStateHeading('No clothing items yet')
            ->emptyStateDescription('Start building your wardrobe by adding your first clothing item.')
            ->emptyStateIcon('heroicon-o-shopping-bag');
    }
}
