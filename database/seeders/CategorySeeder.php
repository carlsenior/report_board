<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory()->create([
            'name' => 'Clothing and Fashion',
        ])->each(function ($category) {
            Product::factory()->createMany([
               [
                   'category_id' => $category->id,
                   'name' => 'Trendsetter T-shirt',
                   'price' => fake()->randomFloat(2, 10, 100),
               ],
               [
                   'category_id' => $category->id,
                   'name' => 'Fashionista Dress',
                   'price' => fake()->randomFloat(2, 10, 100),
               ],
               [
                   'category_id' => $category->id,
                   'name' => 'Style Maven Jeans',
                   'price' => fake()->randomFloat(2, 10, 100),
               ],
               [
                   'category_id' => $category->id,
                   'name' => 'Chic Sweater',
                   'price' => fake()->randomFloat(2, 10, 100),
               ],
               [
                   'category_id' => $category->id,
                   'name' => 'Designer Handbag',
                   'price' => fake()->randomFloat(2, 10, 100),
               ],
               [
                   'category_id' => $category->id,
                   'name' => 'Glamorous Shoes',
                   'price' => fake()->randomFloat(2, 10, 100),
               ]
           ]);
        });
        Category::factory()->create([
            'name' => 'Electronics and Gadgets',
        ])->each(function ($category) {
            Product::factory()->createMany([
                [
                    'category_id' => $category->id,
                    'name' => 'Smart TV Plus',
                    'price' => fake()->randomFloat(2, 10, 1000),
                ],
                [
                    'category_id' => $category->id,
                    'name' => 'Wireless Bluetooth Earphones',
                    'price' => fake()->randomFloat(2, 10, 1000),
                ],
                [
                    'category_id' => $category->id,
                    'name' => 'Portable Power Bank Charger',
                    'price' => fake()->randomFloat(2, 10, 100),
                ],
                [
                    'category_id' => $category->id,
                    'name' => 'Smart Home Security System',
                    'price' => fake()->randomFloat(2, 10, 10000),
                ],
                [
                    'category_id' => $category->id,
                    'name' => 'Virtual Reality Headset',
                    'price' => fake()->randomFloat(2, 10, 1000),
                ],
            ]);
        });

        Category::factory()->create([
            'name' => 'Home and Kitchen',
        ])->each(function ($category) {
            Product::factory()->createMany([
                [
                    'category_id' => $category->id,
                    'name' => 'Instant Pot Duo',
                    'price' => fake()->randomFloat(2, 5, 50),
                ],
                [
                    'category_id' => $category->id,
                    'name' => 'Keurig Coffee Maker',
                    'price' => fake()->randomFloat(2, 3, 10),
                ],
                [
                    'category_id' => $category->id,
                    'name' => 'Ninja Blender',
                    'price' => fake()->randomFloat(2, 10, 100),
                ],
                [
                    'category_id' => $category->id,
                    'name' => 'iRobot Roomba Vacuum',
                    'price' => fake()->randomFloat(2, 10, 100),
                ],
                [
                    'category_id' => $category->id,
                    'name' => 'Hamilton Beach Electric Kettle',
                    'price' => fake()->randomFloat(2, 10, 500),
                ],
            ]);
        });

        Category::factory()->create([
            'name' => 'Beauty and Personal Care',
        ])->each(function ($category) {
            Product::factory()->createMany([
                [
                    'category_id' => $category->id,
                    'name' => 'Revitalizing Argan Oil Hair Mask',
                    'price' => fake()->randomFloat(2, 5, 500),
                ],
                [
                    'category_id' => $category->id,
                    'name' => 'Radiant Glow Facial Serum',
                    'price' => fake()->randomFloat(2, 10, 100),
                ],
                [
                    'category_id' => $category->id,
                    'name' => 'Moisturizing Shea Butter Body Lotion',
                    'price' => fake()->randomFloat(2, 10, 100),
                ],
                [
                    'category_id' => $category->id,
                    'name' => 'Intense Repair Under Eye Cream',
                    'price' => fake()->randomFloat(2, 10, 50),
                ],
                [
                    'category_id' => $category->id,
                    'name' => 'Nourishing Coconut Milk Bath Bombs',
                    'price' => fake()->randomFloat(2, 10, 500),
                ],
            ]);
        });

        Category::factory()->create([
            'name' => 'Health and Fitness',
        ])->each(function ($category) {
            Product::factory()->createMany([
                [
                    'category_id' => $category->id,
                    'name' => 'FitLife Protein Shake',
                    'price' => fake()->randomFloat(2, 5, 50),
                ],
                [
                    'category_id' => $category->id,
                    'name' => 'WellnessPro Fitness Tracker',
                    'price' => fake()->randomFloat(2, 10, 100),
                ],
                [
                    'category_id' => $category->id,
                    'name' => 'VitaBoost Multivitamin Supplement',
                    'price' => fake()->randomFloat(2, 10, 50),
                ],
                [
                    'category_id' => $category->id,
                    'name' => 'FlexiFit Yoga Mat',
                    'price' => fake()->randomFloat(2, 10, 50),
                ],
            ]);
        });

        Category::factory()->create([
            'name' => 'Baby and Maternity',
        ])->each(function ($category) {
            Product::factory()->createMany([
                [
                    'category_id' => $category->id,
                    'name' => 'Baby Bliss',
                    'price' => fake()->randomFloat(2, 5, 50),
                ],
                [
                    'category_id' => $category->id,
                    'name' => 'Mommy\'s Little Helper',
                    'price' => fake()->randomFloat(2, 10, 100),
                ],
                [
                    'category_id' => $category->id,
                    'name' => 'Nurture Nest',
                    'price' => fake()->randomFloat(2, 10, 100),
                ],
            ]);
        });

        Category::factory()->create([
            'name' => 'Sports and Outdoors',
        ])->each(function ($category) {
            Product::factory()->createMany([
                [
                    'category_id' => $category->id,
                    'name' => 'ProFit Sports Exercise Bands Set',
                    'price' => fake()->randomFloat(2, 5, 500),
                ],
                [
                    'category_id' => $category->id,
                    'name' => 'TrailMaster Outdoor Camping Hammock',
                    'price' => fake()->randomFloat(2, 10, 300),
                ],
                [
                    'category_id' => $category->id,
                    'name' => 'PowerShot Pro Basketball Hoop',
                    'price' => fake()->randomFloat(2, 10, 200),
                ],
                [
                    'category_id' => $category->id,
                    'name' => 'FlexGuard Waterproof Sports Armband',
                    'price' => fake()->randomFloat(2, 10, 50),
                ],
                [
                    'category_id' => $category->id,
                    'name' => 'HikePro Trekking Poles Set',
                    'price' => fake()->randomFloat(2, 10, 100),
                ],
            ]);
        });

        Category::factory()->create([
            'name' => 'Other',
        ])->each(function ($category) {
            Product::factory()->createMany([
                [
                    'category_id' => $category->id,
                    'name' => 'Gadgets',
                    'price' => fake()->randomFloat(2, 5, 150),
                ],
                [
                    'category_id' => $category->id,
                    'name' => 'Pet Accessories',
                    'price' => fake()->randomFloat(2, 10, 30),
                ],
                [
                    'category_id' => $category->id,
                    'name' => 'Stationery Supplies',
                    'price' => fake()->randomFloat(2, 10, 200),
                ],
            ]);
        });
    }
}
