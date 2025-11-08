<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Shirts' => [
                'description' => 'All types of shirts and blouses',
                'icon' => 'heroicon-o-user',
                'color' => '#3B82F6',
            ],
            'Pants' => [
                'description' => 'Trousers, jeans, and casual pants',
                'icon' => 'heroicon-o-rectangle-stack',
                'color' => '#8B5CF6',
            ],
            'Dresses' => [
                'description' => 'Formal and casual dresses',
                'icon' => 'heroicon-o-sparkles',
                'color' => '#EC4899',
            ],
            'Shoes' => [
                'description' => 'Footwear collection',
                'icon' => 'heroicon-o-shopping-bag',
                'color' => '#F59E0B',
            ],
            'Accessories' => [
                'description' => 'Belts, hats, scarves, and more',
                'icon' => 'heroicon-o-star',
                'color' => '#10B981',
            ],
            'Outerwear' => [
                'description' => 'Jackets, coats, and sweaters',
                'icon' => 'heroicon-o-shield-check',
                'color' => '#6366F1',
            ],
            'Activewear' => [
                'description' => 'Sports and workout clothing',
                'icon' => 'heroicon-o-bolt',
                'color' => '#EF4444',
            ],
            'Underwear' => [
                'description' => 'Intimate apparel and basics',
                'icon' => 'heroicon-o-squares-2x2',
                'color' => '#06B6D4',
            ],
        ];

        $categoryName = fake()->unique()->randomElement(array_keys($categories));
        $categoryData = $categories[$categoryName];

        return [
            'title' => $categoryName,
            'slug' => \Illuminate\Support\Str::slug($categoryName),
            'description' => $categoryData['description'],
            'icon' => $categoryData['icon'],
            'color' => $categoryData['color'],
            'sort_order' => fake()->numberBetween(1, 100),
            'is_active' => fake()->boolean(90), // 90% active
        ];
    }
}
