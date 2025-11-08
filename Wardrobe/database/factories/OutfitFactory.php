<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Outfit>
 */
class OutfitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $names = [
            'Business Casual',
            'Summer Beach Day',
            'Winter Formal',
            'Weekend Brunch',
            'Gym Workout',
            'Date Night',
            'Office Professional',
            'Casual Friday',
            'Evening Party',
            'Morning Jog',
        ];

        $occasions = ['Casual', 'Formal', 'Business', 'Party', 'Sports', 'Beach', 'Wedding', 'Date'];
        $seasons = ['Spring', 'Summer', 'Fall', 'Winter', 'All Season'];

        return [
            'user_id' => User::factory(),
            'name' => fake()->randomElement($names),
            'description' => fake()->sentence(12),
            'occasion' => fake()->randomElement($occasions),
            'season' => fake()->randomElement($seasons),
            'image' => null, // Will be filled with actual uploads
        ];
    }
}
