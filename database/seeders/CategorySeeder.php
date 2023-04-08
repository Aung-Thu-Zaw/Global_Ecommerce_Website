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
            "name"=>"Apparel & Beauty",
            "slug"=>"apparel-and-beauty",
            "image"=>"apparel-and-beauty.jpeg",
        ]);
        Category::factory()->create([
            "name"=>"Foods & Groceries",
            "slug"=>"foods-and-groceries",
            "image"=>"foods-and-groceries.jpg",
        ]);
        Category::factory()->create([
            "name"=>"Sport Accessories",
            "slug"=>"sport-accessories",
            "image"=>"sport-accessories.jpg",
        ]);
        Category::factory()->create([
            "name"=>"Electronic Devices",
            "slug"=>"electronic-devices",
            "image"=>"electronic-devices.jpg",
        ]);
        Category::factory()->create([
            "name"=>"Electronic Accessories",
            "slug"=>"electronic-accessories",
            "image"=>"electronic-accessories.webp",
        ]);
        Category::factory()->create([
            "name"=>"Home Appliances",
            "slug"=>"home-appliances",
            "image"=>"home-appliances.jpg",
        ]);
        Category::factory()->create([
            "name"=>"Babies & Toys",
            "slug"=>"babies-and-toys",
            "image"=>"babies-and-toys.jpg",
        ]);
        Category::factory()->create([
            "name"=>"Pet Accessories",
            "slug"=>"pet-accessories",
            "image"=>"pet-accessories.webp",
        ]);

        // 1.Apparel And Beauty
        Category::factory()->create(["parent_id"=>1,"name"=>"Hair Care","slug"=>"hair-care","image"=>"hair-care.jpeg"]);
        Category::factory()->create(["parent_id"=>1,"name"=>"Makeup","slug"=>"makeup","image"=>"makeup.jpeg"]);
        Category::factory()->create(["parent_id"=>1,"name"=>"Personal Cares","slug"=>"personal-cares","image"=>"personal-cares.jpg"]);
        Category::factory()->create(["parent_id"=>1,"name"=>"Beauty Tools","slug"=>"beauty-tools","image"=>"beauty-tools.jpg"]);
        Category::factory()->create(["parent_id"=>1,"name"=>"Wedding Apparel & Accessories","slug"=>"wedding-apparel-and-accessories","image"=>"wedding-apparel-and-accessories.jpg"]);
        Category::factory()->create(["parent_id"=>1,"name"=>"Beauty Equipment","slug"=>"beauty-equipment","image"=>"beauty-equipment.jpg"]);
        Category::factory()->create(["parent_id"=>1,"name"=>"Sportswear","slug"=>"sportswear","image"=>"sportswear.jpg"]);
        Category::factory()->create(["parent_id"=>1,"name"=>"Perfume and Fragrance","slug"=>"perfume-and-fragrance","image"=>"perfume-and-fragrance.jpg"]);
        Category::factory()->create(["parent_id"=>1,"name"=>"Men's Care","slug"=>"men's-care","image"=>"men-care.jpeg"]);
        Category::factory()->create(["parent_id"=>1,"name"=>"Ethnic Clothing","slug"=>"ethnic-clothing","image"=>"ethnic-clothing.jpg"]);
        Category::factory()->create(["parent_id"=>1,"name"=>"Garment & Processing Accessories","slug"=>"garment-and-processing-accessories","image"=>"garment-and-processing-accessories.webp"]);
        Category::factory()->create(["parent_id"=>1,"name"=>"Skin Care","slug"=>"skin-care","image"=>"skin-care.jpg"]);
        Category::factory()->create(["parent_id"=>1,"name"=>"Fashion","slug"=>"fashion","image"=>"fashion.webp"]);
        Category::factory()->create(["parent_id"=>1,"name"=>"Other Apparel","slug"=>"other-apparel","image"=>"other-apparel.webp"]);

        // 2.Foods And Groceries
        Category::factory()->create(["parent_id"=>2,"name"=>"Snacks","slug"=>"snacks","image"=>"snacks.jpg"]);
        Category::factory()->create(["parent_id"=>2,"name"=>"Drinks","slug"=>"drinks","image"=>"drinks.jpg"]);
        Category::factory()->create(["parent_id"=>2,"name"=>"Breakfast","slug"=>"breakfast","image"=>"breakfast.jpg"]);
        Category::factory()->create(["parent_id"=>2,"name"=>"Canned Dry & Packaged Foods","slug"=>"canned-dry-and-packaged-foods","image"=>"canned-dry-and-packaged-foods.jpg"]);
        Category::factory()->create(["parent_id"=>2,"name"=>"Jarred Food","slug"=>"jarred-food","image"=>"jarred-food.webp"]);
        Category::factory()->create(["parent_id"=>2,"name"=>"Fruit & Vegetables","slug"=>"fruit-and-vegetables","image"=>"fruit-and-vegetables.jpg"]);
        Category::factory()->create(["parent_id"=>2,"name"=>"Meats","slug"=>"meats","image"=>"meats.jpg"]);
        Category::factory()->create(["parent_id"=>2,"name"=>"Other Goods","slug"=>"other-goods","image"=>"other-goods.jpg"]);

        // 3.port Accessories
        Category::factory()->create(["parent_id"=>3,"name"=>"Water Sports","slug"=>"water-sports","image"=>"water-sports.webp"]);
        Category::factory()->create(["parent_id"=>3,"name"=>"Team Sports","slug"=>"team-sports","image"=>"team-sports.jpg"]);
        Category::factory()->create(["parent_id"=>3,"name"=>"Exercise & Fitness","slug"=>"exercise-and-fitness","image"=>"exercise-and-fitness.jpg"]);
        Category::factory()->create(["parent_id"=>3,"name"=>"Boxing & Material Arts","slug"=>"boxing-and-material-arts","image"=>"boxing-and-material-arts.webp"]);
        Category::factory()->create(["parent_id"=>3,"name"=>"Outdoor Sports","slug"=>"outdoor-sports","image"=>"outdoor-sports.jpg"]);
        Category::factory()->create(["parent_id"=>3,"name"=>"Sports Clothing","slug"=>"sports-clothing","image"=>"sports-clothing.jpg"]);
        Category::factory()->create(["parent_id"=>3,"name"=>"Other Sport Accessories","slug"=>"other-sport-accessories","image"=>"other-sport-accessories.jpg"]);


        // 4.Electronic Devices
        Category::factory()->create(["parent_id"=>4,"name"=>"Mobiles","slug"=>"mobiles","image"=>"mobiles.jpg"]);
        Category::factory()->create(["parent_id"=>4,"name"=>"Tablets","slug"=>"tablets","image"=>"tablets.jpg"]);
        Category::factory()->create(["parent_id"=>4,"name"=>"Security Cameras","slug"=>"security-cameras","image"=>"security-cameras.webp"]);
        Category::factory()->create(["parent_id"=>4,"name"=>"Gaming Consoles","slug"=>"gaming-consoles","image"=>"gaming-consoles.webp"]);
        Category::factory()->create(["parent_id"=>4,"name"=>"Digital Cameras","slug"=>"digital-cameras","image"=>"digital-cameras.webp"]);
        Category::factory()->create(["parent_id"=>4,"name"=>"Desktop Computers","slug"=>"desktop-computers","image"=>"desktop-computers.webp"]);
        Category::factory()->create(["parent_id"=>4,"name"=>"Laptop Comoputers","slug"=>"laptop-computers","image"=>"laptop-computers.jpg"]);
        Category::factory()->create(["parent_id"=>4,"name"=>"Other Devices","slug"=>"other-devices","image"=>"other-devices.jpg"]);

        // 5.Electronic Accessories
        Category::factory()->create(["parent_id"=>5,"name"=>"Mobile Accessories","slug"=>"mobile-accessories","image"=>"mobile-accessories.png"]);
        Category::factory()->create(["parent_id"=>5,"name"=>"Laptop Accessories","slug"=>"laptop-accessories","image"=>"laptop-accessories.webp"]);
        Category::factory()->create(["parent_id"=>5,"name"=>"Desktop Accessories","slug"=>"desktop-acessories","image"=>"desktop-acessories.webp"]);
        Category::factory()->create(["parent_id"=>5,"name"=>"Console Accessories","slug"=>"console-accessories","image"=>"console-accessories.jpeg"]);
        Category::factory()->create(["parent_id"=>5,"name"=>"Printers","slug"=>"printers","image"=>"printers.jpg"]);
        Category::factory()->create(["parent_id"=>5,"name"=>"Chargers, Batteries & Power Supplies","slug"=>"chargers-batterie-and-power-supplies","image"=>"chargers-batterie-and-power-supplies.jpg"]);
        Category::factory()->create(["parent_id"=>5,"name"=>"Storage","slug"=>"storage","image"=>"storage.jpg"]);
        Category::factory()->create(["parent_id"=>5,"name"=>"Cables & Commonly Used Accessories","slug"=>"cables-and-commonly-used-accessories","image"=>"cables-and-commonly-used-accessories.jpg"]);

        // 6.Home Appliances
        Category::factory()->create(["parent_id"=>6,"name"=>"Furniture","slug"=>"furniture","image"=>"furniture.jpeg"]);
        Category::factory()->create(["parent_id"=>6,"name"=>"Cleaning Tools & Accessories","slug"=>"cleaning-tools-and-accessories","image"=>"cleaning-tools-and-accessories.jpeg"]);
        Category::factory()->create(["parent_id"=>6,"name"=>"Laundary & Cleaning","slug"=>"laundary-and-cleaning","image"=>"laundary-and-cleaning.jpeg"]);
        Category::factory()->create(["parent_id"=>6,"name"=>"Kitchen & Dining","slug"=>"kitchen-and-dining","image"=>"kitchen-and-dining.jpg"]);
        Category::factory()->create(["parent_id"=>6,"name"=>"Bath","slug"=>"bath","image"=>"bath.jpg"]);
        Category::factory()->create(["parent_id"=>6,"name"=>"Bedding","slug"=>"bedding","image"=>"bedding.jpg"]);
        Category::factory()->create(["parent_id"=>6,"name"=>"Lighting","slug"=>"lighting","image"=>"lighting.jpg"]);


        // 7.Babies And Toys
        Category::factory()->create(["parent_id"=>7,"name"=>"Baby Clothing","slug"=>"baby-clothing","image"=>"baby-clothing.jpg"]);
        Category::factory()->create(["parent_id"=>7,"name"=>"Feeding","slug"=>"feeding","image"=>"feeding.jpg"]);
        Category::factory()->create(["parent_id"=>7,"name"=>"Toys & Games","slug"=>"toys-and-games","image"=>"toys-and-games.jpg"]);
        Category::factory()->create(["parent_id"=>7,"name"=>"Baby Personal Care","slug"=>"baby-personal-care","image"=>"baby-personal-care.png"]);
        Category::factory()->create(["parent_id"=>7,"name"=>"Diapering & Potty","slug"=>"diapering-and-potty","image"=>"diapering-and-potty.jpg"]);

        // 8.Pet Accessories
        Category::factory()->create(["parent_id"=>8,"name"=>"Cat Foods And Accessories","slug"=>"cat-foods-and-accessories","image"=>"cat-foods-and-accessories.jpeg"]);
        Category::factory()->create(["parent_id"=>8,"name"=>"Dog Foods And Accessories","slug"=>"dog-foods-and-accessories","image"=>"dog-foods-and-accessories.jpg"]);
        Category::factory()->create(["parent_id"=>8,"name"=>"Hunstar Foods And Accessories","slug"=>"hunstar-foods-and-accessories","image"=>"hunstar-foods-and-accessories"]);
        Category::factory()->create(["parent_id"=>8,"name"=>"Other Pet Accessories","slug"=>"other-pet-accessories","image"=>"pet-accessories.jpeg"]);
    }
}
