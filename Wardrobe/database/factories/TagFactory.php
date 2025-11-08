<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tags = [
            ['name' => 'casual', 'color' => '#10B981', 'icon' => 'heroicon-o-home', 'description' => 'Relaxed, everyday wear'],
            ['name' => 'formal', 'color' => '#1F2937', 'icon' => 'heroicon-o-briefcase', 'description' => 'Professional and dressy occasions'],
            ['name' => 'vintage', 'color' => '#92400E', 'icon' => 'heroicon-o-clock', 'description' => 'Classic retro style'],
            ['name' => 'trendy', 'color' => '#EC4899', 'icon' => 'heroicon-o-sparkles', 'description' => 'Latest fashion trends'],
            ['name' => 'comfortable', 'color' => '#3B82F6', 'icon' => 'heroicon-o-heart', 'description' => 'Easy to wear all day'],
            ['name' => 'elegant', 'color' => '#8B5CF6', 'icon' => 'heroicon-o-star', 'description' => 'Sophisticated and refined'],
            ['name' => 'sporty', 'color' => '#EF4444', 'icon' => 'heroicon-o-bolt', 'description' => 'Athletic and active wear'],
            ['name' => 'minimalist', 'color' => '#6B7280', 'icon' => 'heroicon-o-minus', 'description' => 'Simple and clean design'],
            ['name' => 'colorful', 'color' => '#F59E0B', 'icon' => 'heroicon-o-sun', 'description' => 'Bright and vibrant'],
            ['name' => 'modern', 'color' => '#06B6D4', 'icon' => 'heroicon-o-sparkles', 'description' => 'Contemporary style'],
            ['name' => 'classic', 'color' => '#475569', 'icon' => 'heroicon-o-bookmark', 'description' => 'Timeless pieces'],
            ['name' => 'bohemian', 'color' => '#D97706', 'icon' => 'heroicon-o-sun', 'description' => 'Free-spirited and artistic'],
            ['name' => 'preppy', 'color' => '#0891B2', 'icon' => 'heroicon-o-academic-cap', 'description' => 'Clean-cut collegiate style'],
            ['name' => 'summer', 'color' => '#FBBF24', 'icon' => 'heroicon-o-sun', 'description' => 'Perfect for warm weather'],
            ['name' => 'winter', 'color' => '#60A5FA', 'icon' => 'heroicon-o-cloud', 'description' => 'Cold weather appropriate'],
        ];

        $tag = fake()->unique()->randomElement($tags);

        return [
            'name' => $tag['name'],
            'slug' => \Illuminate\Support\Str::slug($tag['name']),
            'description' => $tag['description'],
            'color' => $tag['color'],
            'icon' => $tag['icon'],
        ];
    }
}
