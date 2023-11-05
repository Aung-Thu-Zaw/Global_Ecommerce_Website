<?php

namespace App\Providers;

use App\Models\SeoSetting;
use App\Models\WebsiteSetting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::preventLazyLoading(! app()->isProduction());

        // if (Schema::hasTable('seo_settings')) {
        //     View::share("meta", SeoSetting::findOrFail(1));
        // }

        // if (Schema::hasTable('website_settings')) {
        //     View::share("setting", WebsiteSetting::select("favicon")->first());
        // }
    }
}
