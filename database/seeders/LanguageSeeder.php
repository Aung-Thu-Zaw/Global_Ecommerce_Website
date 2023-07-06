<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // $copyData=file_get_contents(resource_path("lang/en.json"));

        $english=Language::create([
            "name"=>"English",
            "short_name"=>"en"
        ]);
        // file_put_contents(resource_path('lang/'.$english->short_name.'.json'), $copyData);


        $myanmar=Language::create([
            "name"=>"Myanmar",
            "short_name"=>"my"
        ]);
        // file_put_contents(resource_path('lang/'.$myanmar->short_name.'.json'), $copyData);


        $spanish=Language::create([
            "name"=>"Spanish",
            "short_name"=>"sp"
        ]);
        // file_put_contents(resource_path('lang/'.$spanish->short_name.'.json'), $copyData);


        $french=Language::create([
            "name"=>"French",
            "short_name"=>"fr"
        ]);
        // file_put_contents(resource_path('lang/'.$french->short_name.'.json'), $copyData);



    }
}
