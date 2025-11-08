<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\ClothingItem;
use App\Models\Outfit;
use App\Models\Tag;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Clothing Items', ClothingItem::count())
                ->description('Items in wardrobe')
                ->descriptionIcon('heroicon-o-shopping-bag')
                ->color('success')
                ->chart([7, 12, 15, 18, 22, 28, ClothingItem::count()]),

            Stat::make('Total Outfits', Outfit::count())
                ->description('Outfit combinations')
                ->descriptionIcon('heroicon-o-squares-2x2')
                ->color('primary')
                ->chart([3, 5, 8, 12, 15, 20, Outfit::count()]),

            Stat::make('Categories', Category::where('is_active', true)->count())
                ->description('Active categories')
                ->descriptionIcon('heroicon-o-rectangle-stack')
                ->color('warning'),

            Stat::make('Tags', Tag::count())
                ->description('Available tags')
                ->descriptionIcon('heroicon-o-tag')
                ->color('info'),

            Stat::make('Users', User::count())
                ->description('Registered users')
                ->descriptionIcon('heroicon-o-users')
                ->color('danger'),

            Stat::make('Favorite Items', ClothingItem::where('is_favorite', true)->count())
                ->description('Marked as favorite')
                ->descriptionIcon('heroicon-o-heart')
                ->color('danger'),
        ];
    }
}
