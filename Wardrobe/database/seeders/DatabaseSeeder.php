<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\ClothingItem;
use App\Models\Outfit;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Seeding database with real clothing images...');

        // Create demo user with known credentials
        $this->command->info('Creating demo user...');
        $demoUser = User::firstOrCreate(
            ['email' => 'demo@wardrobe.com'],
            [
                'name' => 'Demo User',
                'password' => bcrypt('password123'),
            ]
        );

        // Clear existing data for demo user
        $this->command->info('Clearing old clothing items...');
        ClothingItem::where('user_id', $demoUser->id)->delete();
        
        // Create categories
        $this->command->info('Creating categories...');
        $categories = [
            ['title' => 'Tops', 'slug' => 'tops', 'description' => 'T-shirts, shirts, blouses'],
            ['title' => 'Bottoms', 'slug' => 'bottoms', 'description' => 'Pants, jeans, skirts'],
            ['title' => 'Dresses', 'slug' => 'dresses', 'description' => 'Casual and formal dresses'],
            ['title' => 'Outerwear', 'slug' => 'outerwear', 'description' => 'Jackets, coats, blazers'],
            ['title' => 'Shoes', 'slug' => 'shoes', 'description' => 'Sneakers, boots, heels'],
            ['title' => 'Accessories', 'slug' => 'accessories', 'description' => 'Bags, jewelry, hats'],
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[] = Category::firstOrCreate(
                ['slug' => $cat['slug']],
                [
                    'title' => $cat['title'],
                    'description' => $cat['description'],
                    'is_active' => true,
                ]
            );
        }

        // Create tags
        $this->command->info('Creating tags...');
        $tagNames = ['Casual', 'Formal', 'Summer', 'Winter', 'Vintage', 'Modern', 'Sporty', 'Elegant'];
        $tagModels = [];
        foreach ($tagNames as $tagName) {
            $tagModels[] = Tag::firstOrCreate(['name' => $tagName]);
        }

        // Create clothing items with real images from Unsplash
        $this->command->info('Creating clothing items with images...');
        
        $clothingItems = [
            // Tops
            ['name' => 'White Cotton T-Shirt', 'category' => 'Tops', 'color' => 'White', 'brand' => 'H&M', 'size' => 'M', 'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400'],
            ['name' => 'Blue Denim Shirt', 'category' => 'Tops', 'color' => 'Blue', 'brand' => 'Levi\'s', 'size' => 'L', 'image' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=400'],
            ['name' => 'Black Polo Shirt', 'category' => 'Tops', 'color' => 'Black', 'brand' => 'Ralph Lauren', 'size' => 'M', 'image' => 'https://images.unsplash.com/photo-1586790170083-2f9ceadc732d?w=400'],
            
            // Bottoms
            ['name' => 'Dark Blue Jeans', 'category' => 'Bottoms', 'color' => 'Dark Blue', 'brand' => 'Levi\'s', 'size' => '32', 'image' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=400'],
            ['name' => 'Black Chinos', 'category' => 'Bottoms', 'color' => 'Black', 'brand' => 'Zara', 'size' => '32', 'image' => 'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?w=400'],
            ['name' => 'Grey Joggers', 'category' => 'Bottoms', 'color' => 'Grey', 'brand' => 'Nike', 'size' => 'M', 'image' => 'https://images.unsplash.com/photo-1517438476312-10d79c077509?w=400'],
            
            // Dresses
            ['name' => 'Summer Floral Dress', 'category' => 'Dresses', 'color' => 'Multicolor', 'brand' => 'Zara', 'size' => 'S', 'image' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=400'],
            ['name' => 'Black Evening Dress', 'category' => 'Dresses', 'color' => 'Black', 'brand' => 'H&M', 'size' => 'M', 'image' => 'https://images.unsplash.com/photo-1566174053879-31528523f8ae?w=400'],
            
            // Outerwear
            ['name' => 'Leather Jacket', 'category' => 'Outerwear', 'color' => 'Black', 'brand' => 'Zara', 'size' => 'L', 'image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=400'],
            ['name' => 'Denim Jacket', 'category' => 'Outerwear', 'color' => 'Blue', 'brand' => 'Levi\'s', 'size' => 'M', 'image' => 'https://images.unsplash.com/photo-1576995853123-5a10305d93c0?w=400'],
            ['name' => 'Wool Coat', 'category' => 'Outerwear', 'color' => 'Grey', 'brand' => 'Uniqlo', 'size' => 'L', 'image' => 'https://images.unsplash.com/photo-1539533018447-63fcce2678e3?w=400'],
            
            // Shoes
            ['name' => 'White Sneakers', 'category' => 'Shoes', 'color' => 'White', 'brand' => 'Adidas', 'size' => '42', 'image' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=400'],
            ['name' => 'Brown Leather Boots', 'category' => 'Shoes', 'color' => 'Brown', 'brand' => 'Timberland', 'size' => '43', 'image' => 'https://images.unsplash.com/photo-1638247025967-b4e38f787b76?w=400'],
            ['name' => 'Black Loafers', 'category' => 'Shoes', 'color' => 'Black', 'brand' => 'Clarks', 'size' => '42', 'image' => 'https://images.unsplash.com/photo-1533867617858-e7b97e060509?w=400'],
            
            // Accessories
            ['name' => 'Leather Watch', 'category' => 'Accessories', 'color' => 'Brown', 'brand' => 'Fossil', 'size' => 'One Size', 'image' => 'https://images.unsplash.com/photo-1524805444758-089113d48a6d?w=400'],
            ['name' => 'Black Backpack', 'category' => 'Accessories', 'color' => 'Black', 'brand' => 'Herschel', 'size' => 'One Size', 'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400'],
            ['name' => 'Sunglasses', 'category' => 'Accessories', 'color' => 'Black', 'brand' => 'Ray-Ban', 'size' => 'One Size', 'image' => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=400'],
        ];

        foreach ($clothingItems as $item) {
            $category = collect($categoryModels)->firstWhere('title', $item['category']);
            
            if (!$category) {
                $this->command->error("Category not found: {$item['category']}");
                continue;
            }
            
            ClothingItem::create([
                'user_id' => $demoUser->id,
                'name' => $item['name'],
                'category_id' => $category->id,
                'color' => $item['color'],
                'brand' => $item['brand'],
                'size' => $item['size'],
                'image' => $item['image'],
                'description' => 'Added via seeder',
            ]);
        }

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('📧 Demo user email: demo@wardrobe.com');
        $this->command->info('🔑 Demo user password: password123');
    }
}
