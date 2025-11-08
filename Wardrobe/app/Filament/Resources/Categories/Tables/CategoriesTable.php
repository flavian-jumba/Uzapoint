<?php

namespace App\Filament\Resources\Categories\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Image')
                    ->circular()
                    ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->title) . '&color=7F9CF5&background=EBF4FF')
                    ->size(50),
                    
                TextColumn::make('title')
                    ->label('Category Name')
                    ->sortable()
                    ->searchable()
                    ->weight('medium')
                    ->size('sm'),
                    
                TextColumn::make('slug')
                    ->label('Slug')
                    ->copyable()
                    ->copyMessage('Slug copied to clipboard')
                    ->size('xs')
                    ->color('gray')
                    ->toggleable(),
                    
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->description)
                    ->wrap()
                    ->toggleable(),
                    
                TextColumn::make('icon')
                    ->label('Icon')
                    ->icon(fn ($record) => $record->icon)
                    ->size('lg')
                    ->toggleable(),
                    
                ColorColumn::make('color')
                    ->label('Color')
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->toggleable(),
                    
                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable()
                    ->numeric()
                    ->alignCenter()
                    ->badge()
                    ->color('info'),
                    
                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),
                    
                TextColumn::make('clothingItems_count')
                    ->label('Items')
                    ->counts('clothingItems')
                    ->badge()
                    ->color('primary')
                    ->alignCenter()
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
                TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->placeholder('All categories')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only')
                    ->native(false),
                    
                SelectFilter::make('sort_order')
                    ->label('Sort Order Range')
                    ->options([
                        '0-10' => '0-10',
                        '11-50' => '11-50',
                        '51-100' => '51+',
                    ])
                    ->query(function ($query, $data) {
                        if (!$data['value']) return $query;
                        
                        return match($data['value']) {
                            '0-10' => $query->whereBetween('sort_order', [0, 10]),
                            '11-50' => $query->whereBetween('sort_order', [11, 50]),
                            '51-100' => $query->where('sort_order', '>=', 51),
                            default => $query,
                        };
                    }),
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
            ->defaultSort('sort_order', 'asc')
            ->poll('30s')
            ->striped()
            ->emptyStateHeading('No categories yet')
            ->emptyStateDescription('Create your first clothing category to get started.')
            ->emptyStateIcon('heroicon-o-rectangle-stack');
    }
}