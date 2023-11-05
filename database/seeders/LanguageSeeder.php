<?php

namespace Database\Seeders;

use App\Models\Language;
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
        Language::create([
            'name' => 'English',
            'short_name' => 'en',
        ]);

        Language::create([
            'name' => 'Myanmar',
            'short_name' => 'my',
        ]);

        Language::create([
            'name' => 'Korean',
            'short_name' => 'ko',
        ]);

        Language::create([
            'name' => 'Japanese',
            'short_name' => 'ja',
        ]);

        Language::create([
            'name' => 'French',
            'short_name' => 'fr',
        ]);

        Language::create([
            'name' => 'Chinese',
            'short_name' => 'zh',
        ]);

        Language::create([
            'name' => 'Arabic',
            'short_name' => 'ar',
        ]);

        Language::create([
            'name' => 'Thai',
            'short_name' => 'th',
        ]);

        Language::create([
            'name' => 'Hindi',
            'short_name' => 'hi',
        ]);
    }
}
