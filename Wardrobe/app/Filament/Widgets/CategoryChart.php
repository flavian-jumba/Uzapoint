<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class CategoryChart extends ChartWidget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    protected ?string $heading = 'Clothing Items by Category';

    protected ?string $description = 'Distribution of items across categories';

    protected function getData(): array
    {
        $categories = Category::query()
            ->withCount('clothingItems')
            ->orderBy('clothing_items_count', 'desc')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Clothing Items',
                    'data' => $categories->pluck('clothing_items_count')->toArray(),
                    'backgroundColor' => $categories->map(fn ($category) => $category->color ?? '#6B7280')->toArray(),
                    'borderColor' => '#ffffff',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $categories->pluck('title')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
        ];
    }
}
