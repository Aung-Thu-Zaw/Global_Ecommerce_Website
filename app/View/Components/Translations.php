<?php

namespace App\View\Components;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\View\Component;

class Translations extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $locale = session('locale') ? session('locale') : App::getLocale();

        $translations = Cache::rememberForever("translations_$locale", function () use ($locale) {
            $allTranslations = [];

            // List of language directories to include
            $directories = [
                resource_path('lang/dashboard'),
                resource_path('lang'),
                // Add more directories as needed
            ];

            // Iterate through each directory and load translations
            foreach ($directories as $directory) {
                if (File::exists($directory)) {
                    // Load PHP language files
                    $phpFilePath = $directory."/$locale.php";
                    if (File::exists($phpFilePath)) {
                        $phpTranslations = Arr::dot(File::getRequire($phpFilePath));
                        $allTranslations = array_merge($allTranslations, $phpTranslations);
                    }

                    // Load JSON language files
                    $jsonFilePath = $directory."/$locale.json";
                    if (File::exists($jsonFilePath)) {
                        $jsonTranslations = json_decode(File::get($jsonFilePath), true);
                        $allTranslations = array_merge($allTranslations, $jsonTranslations);
                    }
                }
            }

            return $allTranslations;
        });

        return view('components.translations', compact('translations'));
    }
}
