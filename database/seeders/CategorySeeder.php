<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()->create([
            'name' => 'Apparel & Beauty',
            'slug' => 'apparel-and-beauty',
            'image' => 'apparel-and-beauty.jpg',
        ]);
        Category::factory()->create([
            'name' => 'Foods & Groceries',
            'slug' => 'foods-and-groceries',
            'image' => 'food-and-groceries.jpg',
        ]);
        Category::factory()->create([
            'name' => 'Sport Accessories',
            'slug' => 'sport-accessories',
            'image' => 'sport-accessories.jpeg',
        ]);
        Category::factory()->create([
            'name' => 'Electronic Devices',
            'slug' => 'electronic-devices',
            'image' => 'electronic-devices.webp',
        ]);
        Category::factory()->create([
            'name' => 'Electronic Accessories',
            'slug' => 'electronic-accessories',
            'image' => 'electronic-accessories.webp',
        ]);
        Category::factory()->create([
            'name' => 'Home Appliances',
            'slug' => 'home-appliances',
            'image' => 'home-appliance.jpg',
        ]);
        Category::factory()->create([
            'name' => 'Babies & Toys',
            'slug' => 'babies-and-toys',
            'image' => 'babies-and-toys.jpg',
        ]);
        Category::factory()->create([
            'name' => 'Pet Accessories',
            'slug' => 'pet-accessories',
            'image' => 'pet-accessories.jpg',
        ]);

        // 1.Apparel And Beauty
        Category::factory()->create(['parent_id' => 1, 'name' => 'Hair Care', 'slug' => 'hair-care', 'image' => 'hair-care.jpg']);
        Category::factory()->create(['parent_id' => 1, 'name' => 'Makeup', 'slug' => 'makeup', 'image' => 'make-up.jpg']);
        Category::factory()->create(['parent_id' => 1, 'name' => 'Personal Cares', 'slug' => 'personal-cares', 'image' => 'personal-care.jpg']);
        Category::factory()->create(['parent_id' => 1, 'name' => 'Beauty Tools', 'slug' => 'beauty-tools', 'image' => 'beauty-tools.jpg']);
        Category::factory()->create(['parent_id' => 1, 'name' => 'Wedding Apparel & Accessories', 'slug' => 'wedding-apparel-and-accessories', 'image' => 'wedding-apparel-and-accessories.jpg']);
        Category::factory()->create(['parent_id' => 1, 'name' => 'Beauty Equipment', 'slug' => 'beauty-equipment', 'image' => 'beauty-equiments.jpg']);
        Category::factory()->create(['parent_id' => 1, 'name' => 'Sportswear', 'slug' => 'sportswear', 'image' => 'sport-wear.jpg']);
        Category::factory()->create(['parent_id' => 1, 'name' => 'Perfume and Fragrance', 'slug' => 'perfume-and-fragrance', 'image' => 'perfume-and-fragrance.jpg']);
        Category::factory()->create(['parent_id' => 1, 'name' => "Men's Care", 'slug' => "men's-care", 'image' => 'men-care.jpg']);
        Category::factory()->create(['parent_id' => 1, 'name' => 'Ethnic Clothing', 'slug' => 'ethnic-clothing', 'image' => 'ethnic-clothing.jpg']);
        Category::factory()->create(['parent_id' => 1, 'name' => 'Garment & Processing Accessories', 'slug' => 'garment-and-processing-accessories', 'image' => 'garment-and-processing-accessories.webp']);
        Category::factory()->create(['parent_id' => 1, 'name' => 'Skin Care', 'slug' => 'skin-care', 'image' => 'skin-care.jpeg']);
        Category::factory()->create(['parent_id' => 1, 'name' => 'Fashion', 'slug' => 'fashion', 'image' => 'fashion.jpg']);
        Category::factory()->create(['parent_id' => 1, 'name' => 'Other Apparel', 'slug' => 'other-apparel', 'image' => 'other-apparel.jpg']);

        // 2.Foods And Groceries
        Category::factory()->create(['parent_id' => 2, 'name' => 'Snacks', 'slug' => 'snacks', 'image' => 'snacks.jpg']);
        Category::factory()->create(['parent_id' => 2, 'name' => 'Drinks', 'slug' => 'drinks', 'image' => 'drinks.jpg']);
        Category::factory()->create(['parent_id' => 2, 'name' => 'Breakfast', 'slug' => 'breakfast', 'image' => 'breakfast.jpg']);
        Category::factory()->create(['parent_id' => 2, 'name' => 'Canned Dry & Packaged Foods', 'slug' => 'canned-dry-and-packaged-foods', 'image' => 'canned-dry-packaged-foods.jpg']);
        Category::factory()->create(['parent_id' => 2, 'name' => 'Jarred Food', 'slug' => 'jarred-food', 'image' => 'jarred-food.jpg']);
        Category::factory()->create(['parent_id' => 2, 'name' => 'Fruit & Vegetables', 'slug' => 'fruit-and-vegetables', 'image' => 'fruits-and-vegetables.webp']);
        Category::factory()->create(['parent_id' => 2, 'name' => 'Meats', 'slug' => 'meats', 'image' => 'meats.jpg']);
        Category::factory()->create(['parent_id' => 2, 'name' => 'Other Goods', 'slug' => 'other-goods', 'image' => 'other-goods.jpg']);

        // 3.port Accessories
        Category::factory()->create(['parent_id' => 3, 'name' => 'Water Sports', 'slug' => 'water-sports', 'image' => 'water-sports.jpg']);
        Category::factory()->create(['parent_id' => 3, 'name' => 'Team Sports', 'slug' => 'team-sports', 'image' => 'team-sports.webp']);
        Category::factory()->create(['parent_id' => 3, 'name' => 'Exercise & Fitness', 'slug' => 'exercise-and-fitness', 'image' => 'exercise-and-fitness.jpg']);
        Category::factory()->create(['parent_id' => 3, 'name' => 'Boxing & Material Arts', 'slug' => 'boxing-and-material-arts', 'image' => 'boxing-and-martial-arts.jpg']);
        Category::factory()->create(['parent_id' => 3, 'name' => 'Outdoor Sports', 'slug' => 'outdoor-sports', 'image' => 'outdoor-sports.jpg']);
        Category::factory()->create(['parent_id' => 3, 'name' => 'Sports Clothing', 'slug' => 'sports-clothing', 'image' => 'sport-clothing.jpg']);
        Category::factory()->create(['parent_id' => 3, 'name' => 'Other Sport Accessories', 'slug' => 'other-sport-accessories', 'image' => 'other-sport-accessories.jpg']);

        // 4.Electronic Devices
        Category::factory()->create(['parent_id' => 4, 'name' => 'Mobiles', 'slug' => 'mobiles', 'image' => 'mobiles.webp']);
        Category::factory()->create(['parent_id' => 4, 'name' => 'Tablets', 'slug' => 'tablets', 'image' => 'tablets.webp']);
        Category::factory()->create(['parent_id' => 4, 'name' => 'Security Cameras', 'slug' => 'security-cameras', 'image' => 'security-cameras.jpg']);
        Category::factory()->create(['parent_id' => 4, 'name' => 'Gaming Consoles', 'slug' => 'gaming-consoles', 'image' => 'gaming-console.webp']);
        Category::factory()->create(['parent_id' => 4, 'name' => 'Digital Cameras', 'slug' => 'digital-cameras', 'image' => 'digital-cameras.webp']);
        Category::factory()->create(['parent_id' => 4, 'name' => 'Computers', 'slug' => 'computers', 'image' => 'computers.jpg']);
        Category::factory()->create(['parent_id' => 4, 'name' => 'Other Devices', 'slug' => 'other-devices', 'image' => 'other-devices.jpg']);

        // 5.Electronic Accessories
        Category::factory()->create(['parent_id' => 5, 'name' => 'Mobile Accessories', 'slug' => 'mobile-accessories', 'image' => 'mobile-accessories.webp']);
        Category::factory()->create(['parent_id' => 5, 'name' => 'Laptop Accessories', 'slug' => 'laptop-accessories', 'image' => 'laptop-accessories.png']);
        Category::factory()->create(['parent_id' => 5, 'name' => 'Desktop Accessories', 'slug' => 'desktop-acessories', 'image' => 'desktop-accessories.webp']);
        Category::factory()->create(['parent_id' => 5, 'name' => 'Console Accessories', 'slug' => 'console-accessories', 'image' => 'console-accessories.webp']);
        Category::factory()->create(['parent_id' => 5, 'name' => 'Printers', 'slug' => 'printers', 'image' => 'printers.jpg']);
        Category::factory()->create(['parent_id' => 5, 'name' => 'Chargers, Batteries & Power Supplies', 'slug' => 'chargers-batterie-and-power-supplies', 'image' => 'chargers-batteries-and-power-supplies.png']);
        Category::factory()->create(['parent_id' => 5, 'name' => 'Storage', 'slug' => 'storage', 'image' => 'storages.png']);
        Category::factory()->create(['parent_id' => 5, 'name' => 'Cables & Commonly Used Accessories', 'slug' => 'cables-and-commonly-used-accessories', 'image' => 'cables-and-commonly-used-accessories.webp']);

        // 6.Home Appliances
        Category::factory()->create(['parent_id' => 6, 'name' => 'Furniture', 'slug' => 'furniture', 'image' => 'furniture.jpg']);
        Category::factory()->create(['parent_id' => 6, 'name' => 'Cleaning Tools & Accessories', 'slug' => 'cleaning-tools-and-accessories', 'image' => 'cleaning-tools-and-accessories.webp']);
        Category::factory()->create(['parent_id' => 6, 'name' => 'Laundary & Cleaning', 'slug' => 'laundary-and-cleaning', 'image' => 'laundary-and-cleaning.jpg']);
        Category::factory()->create(['parent_id' => 6, 'name' => 'Kitchen & Dining', 'slug' => 'kitchen-and-dining', 'image' => 'kitchen-and-dining.jpg']);
        Category::factory()->create(['parent_id' => 6, 'name' => 'Bath Accessories', 'slug' => 'bath-accessories', 'image' => 'bath-accessories.jpg']);
        Category::factory()->create(['parent_id' => 6, 'name' => 'Bed Accessories', 'slug' => 'bed-accessories', 'image' => 'bed-accessories.jpg']);
        Category::factory()->create(['parent_id' => 6, 'name' => 'Lighting', 'slug' => 'lighting', 'image' => 'lighting.jpg']);

        // 7.Babies And Toys
        Category::factory()->create(['parent_id' => 7, 'name' => 'Baby Clothing', 'slug' => 'baby-clothing', 'image' => 'baby-clothing.jpg']);
        Category::factory()->create(['parent_id' => 7, 'name' => 'Feeding', 'slug' => 'feeding', 'image' => 'feeding.jpg']);
        Category::factory()->create(['parent_id' => 7, 'name' => 'Toys & Games', 'slug' => 'toys-and-games', 'image' => 'toys-and-games.webp']);
        Category::factory()->create(['parent_id' => 7, 'name' => 'Baby Personal Care', 'slug' => 'baby-personal-care', 'image' => 'baby-personal-care.jpg']);
        Category::factory()->create(['parent_id' => 7, 'name' => 'Diapering & Potty', 'slug' => 'diapering-and-potty', 'image' => 'diapering-and-potty.webp']);

        // 8.Pet Accessories
        Category::factory()->create(['parent_id' => 8, 'name' => 'Cat Foods And Accessories', 'slug' => 'cat-foods-and-accessories', 'image' => 'cat-food-and-accessories.webp']);
        Category::factory()->create(['parent_id' => 8, 'name' => 'Dog Foods And Accessories', 'slug' => 'dog-foods-and-accessories', 'image' => 'dog-food-and-accessories.jpg']);
        Category::factory()->create(['parent_id' => 8, 'name' => 'Other Pet Accessories', 'slug' => 'other-pet-accessories', 'image' => 'other-pet-accessories.jpg']);
    }
}
