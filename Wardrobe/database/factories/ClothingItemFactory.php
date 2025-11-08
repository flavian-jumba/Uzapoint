<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClothingItem>
 */
class ClothingItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $names = [
            'Classic White Shirt', 'Blue Denim Jeans', 'Black Leather Jacket',
            'Red Summer Dress', 'Grey Hoodie', 'Khaki Chinos',
            'Striped T-Shirt', 'Floral Blouse', 'Navy Blazer',
            'Cotton Polo Shirt', 'Slim Fit Trousers', 'Wool Coat',
            'Casual Shorts', 'Pencil Skirt', 'Knit Sweater',
            'Running Shoes', 'Leather Boots', 'Canvas Sneakers',
        ];

        $colors = ['#000000', '#FFFFFF', '#3B82F6', '#EF4444', '#6B7280', '#1E3A8A', '#92400E', '#10B981', '#78350F', '#F5F5DC'];
        $brands = ['Nike', 'Adidas', 'Zara', 'H&M', 'Uniqlo', 'Levi\'s', 'Gap', 'Tommy Hilfiger', 'Ralph Lauren', 'Calvin Klein'];
        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
        $seasons = ['Spring', 'Summer', 'Fall', 'Winter', 'All Season'];
        $conditions = ['New', 'Like New', 'Good', 'Fair'];

        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'name' => fake()->randomElement($names),
            'description' => fake()->sentence(10),
            'color' => fake()->randomElement($colors),
            'brand' => fake()->randomElement($brands),
            'size' => fake()->randomElement($sizes),
            'image' => null, // Will be filled with actual uploads
            'price' => fake()->boolean(70) ? fake()->randomFloat(2, 10, 300) : null,
            'season' => fake()->randomElement($seasons),
            'condition' => fake()->randomElement($conditions),
            'purchase_date' => fake()->boolean(60) ? fake()->dateTimeBetween('-2 years', 'now') : null,
            'is_favorite' => fake()->boolean(20), // 20% chance of being favorite
        ];
    }
}
