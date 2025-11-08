<?php

namespace App\Filament\Resources\Tags\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Filters\Filter;

class TagsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Tag Name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->badge()
                    ->color(fn ($record) => $record->color ?? 'primary')
                    ->icon(fn ($record) => $record->icon ?? 'heroicon-o-tag'),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Slug copied!')
                    ->size('xs')
                    ->color('gray')
                    ->toggleable(),

                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->description)
                    ->placeholder('No description')
                    ->wrap()
                    ->toggleable(),

                ColorColumn::make('color')
                    ->label('Color')
                    ->copyable()
                    ->copyMessage('Color copied!')
                    ->toggleable(),

                TextColumn::make('icon')
                    ->label('Icon')
                    ->icon(fn ($record) => $record->icon)
                    ->size('lg')
                    ->placeholder('N/A')
                    ->toggleable(),

                TextColumn::make('clothingItems_count')
                    ->label('Used in Items')
                    ->counts('clothingItems')
                    ->badge()
                    ->color('success')
                    ->alignCenter()
                    ->sortable(),

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
                Filter::make('has_items')
                    ->label('With Items')
                    ->query(fn ($query) => $query->has('clothingItems')),

                Filter::make('no_items')
                    ->label('Without Items')
                    ->query(fn ($query) => $query->doesntHave('clothingItems')),
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
            ->defaultSort('name', 'asc')
            ->poll('30s')
            ->striped()
            ->emptyStateHeading('No tags yet')
            ->emptyStateDescription('Create tags to help organize and categorize your clothing items.')
            ->emptyStateIcon('heroicon-o-tag');
    }
}