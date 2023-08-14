<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Fashion
        BlogPost::factory()->create(["blog_category_id"=>1,"image"=>"blog-post-1.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>1,"image"=>"blog-post-2.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>1,"image"=>"blog-post-3.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>1,"image"=>"blog-post-4.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>1,"image"=>"blog-post-5.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>1,"image"=>"blog-post-6.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>1,"image"=>"blog-post-7.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>1,"image"=>"blog-post-8.png"]);
        BlogPost::factory()->create(["blog_category_id"=>1,"image"=>"blog-post-9.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>1,"image"=>"blog-post-10.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>1,"image"=>"blog-post-34.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>1,"image"=>"blog-post-35.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>1,"image"=>"blog-post-36.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>1,"image"=>"blog-post-37.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>1,"image"=>"blog-post-38.jpg"]);

        // Food
        BlogPost::factory()->create(["blog_category_id"=>2,"image"=>"blog-post-11.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>2,"image"=>"blog-post-12.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>2,"image"=>"blog-post-13.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>2,"image"=>"blog-post-14.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>2,"image"=>"blog-post-15.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>2,"image"=>"blog-post-16.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>2,"image"=>"blog-post-17.jpeg"]);
        BlogPost::factory()->create(["blog_category_id"=>2,"image"=>"blog-post-18.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>2,"image"=>"blog-post-19.png"]);
        BlogPost::factory()->create(["blog_category_id"=>2,"image"=>"blog-post-20.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>2,"image"=>"blog-post-34.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>2,"image"=>"blog-post-35.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>2,"image"=>"blog-post-36.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>2,"image"=>"blog-post-37.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>2,"image"=>"blog-post-38.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>2,"image"=>"blog-post-39.webp"]);

        // Lifestyle
        BlogPost::factory()->create(["blog_category_id"=>3,"image"=>"blog-post-21.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>3,"image"=>"blog-post-22.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>3,"image"=>"blog-post-23.png"]);
        BlogPost::factory()->create(["blog_category_id"=>3,"image"=>"blog-post-24.png"]);
        BlogPost::factory()->create(["blog_category_id"=>3,"image"=>"blog-post-25.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>3,"image"=>"blog-post-26.png"]);
        BlogPost::factory()->create(["blog_category_id"=>3,"image"=>"blog-post-27.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>3,"image"=>"blog-post-28.png"]);
        BlogPost::factory()->create(["blog_category_id"=>3,"image"=>"blog-post-29.png"]);
        BlogPost::factory()->create(["blog_category_id"=>3,"image"=>"blog-post-30.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>3,"image"=>"blog-post-42.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>3,"image"=>"blog-post-43.png"]);
        BlogPost::factory()->create(["blog_category_id"=>3,"image"=>"blog-post-44.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>3,"image"=>"blog-post-45.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>3,"image"=>"blog-post-46.png"]);

        // Sports
        BlogPost::factory()->create(["blog_category_id"=>4,"image"=>"blog-post-31.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>4,"image"=>"blog-post-32.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>4,"image"=>"blog-post-33.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>4,"image"=>"blog-post-34.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>4,"image"=>"blog-post-35.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>4,"image"=>"blog-post-36.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>4,"image"=>"blog-post-37.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>4,"image"=>"blog-post-38.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>4,"image"=>"blog-post-39.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>4,"image"=>"blog-post-40.webp"]);

        // Technology
        BlogPost::factory()->create(["blog_category_id"=>5,"image"=>"blog-post-41.png"]);
        BlogPost::factory()->create(["blog_category_id"=>5,"image"=>"blog-post-42.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>5,"image"=>"blog-post-43.png"]);
        BlogPost::factory()->create(["blog_category_id"=>5,"image"=>"blog-post-44.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>5,"image"=>"blog-post-45.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>5,"image"=>"blog-post-46.png"]);
        BlogPost::factory()->create(["blog_category_id"=>5,"image"=>"blog-post-47.png"]);
        BlogPost::factory()->create(["blog_category_id"=>5,"image"=>"blog-post-48.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>5,"image"=>"blog-post-49.jpeg"]);
        BlogPost::factory()->create(["blog_category_id"=>5,"image"=>"blog-post-50.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>5,"image"=>"blog-post-36.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>5,"image"=>"blog-post-37.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>5,"image"=>"blog-post-38.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>5,"image"=>"blog-post-39.webp"]);


        // Travel
        BlogPost::factory()->create(["blog_category_id"=>6,"image"=>"blog-post-51.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>6,"image"=>"blog-post-52.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>6,"image"=>"blog-post-53.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>6,"image"=>"blog-post-54.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>6,"image"=>"blog-post-55.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>6,"image"=>"blog-post-56.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>6,"image"=>"blog-post-57.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>6,"image"=>"blog-post-58.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>6,"image"=>"blog-post-59.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>6,"image"=>"blog-post-60.jpeg"]);
        BlogPost::factory()->create(["blog_category_id"=>6,"image"=>"blog-post-45.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>6,"image"=>"blog-post-46.png"]);
        BlogPost::factory()->create(["blog_category_id"=>6,"image"=>"blog-post-47.png"]);
        BlogPost::factory()->create(["blog_category_id"=>6,"image"=>"blog-post-48.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>6,"image"=>"blog-post-19.png"]);
        BlogPost::factory()->create(["blog_category_id"=>6,"image"=>"blog-post-10.webp"]);


        // Beauty And Health
        BlogPost::factory()->create(["blog_category_id"=>7,"image"=>"blog-post-11.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>7,"image"=>"blog-post-12.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>7,"image"=>"blog-post-23.png"]);
        BlogPost::factory()->create(["blog_category_id"=>7,"image"=>"blog-post-24.png"]);
        BlogPost::factory()->create(["blog_category_id"=>7,"image"=>"blog-post-45.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>7,"image"=>"blog-post-26.png"]);
        BlogPost::factory()->create(["blog_category_id"=>7,"image"=>"blog-post-47.png"]);
        BlogPost::factory()->create(["blog_category_id"=>7,"image"=>"blog-post-48.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>7,"image"=>"blog-post-19.png"]);
        BlogPost::factory()->create(["blog_category_id"=>7,"image"=>"blog-post-10.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>7,"image"=>"blog-post-54.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>7,"image"=>"blog-post-55.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>7,"image"=>"blog-post-56.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>7,"image"=>"blog-post-57.jpg"]);


        // Home Improvement
        BlogPost::factory()->create(["blog_category_id"=>8,"image"=>"blog-post-21.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>8,"image"=>"blog-post-22.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>8,"image"=>"blog-post-13.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>8,"image"=>"blog-post-34.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>8,"image"=>"blog-post-45.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>8,"image"=>"blog-post-46.png"]);
        BlogPost::factory()->create(["blog_category_id"=>8,"image"=>"blog-post-47.png"]);
        BlogPost::factory()->create(["blog_category_id"=>8,"image"=>"blog-post-48.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>8,"image"=>"blog-post-19.png"]);
        BlogPost::factory()->create(["blog_category_id"=>8,"image"=>"blog-post-10.webp"]);
        BlogPost::factory()->create(["blog_category_id"=>8,"image"=>"blog-post-21.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>8,"image"=>"blog-post-22.jpg"]);
        BlogPost::factory()->create(["blog_category_id"=>8,"image"=>"blog-post-23.png"]);
        BlogPost::factory()->create(["blog_category_id"=>8,"image"=>"blog-post-24.png"]);

    }
}
