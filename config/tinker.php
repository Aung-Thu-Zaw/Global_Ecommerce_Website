<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Console Commands
    |--------------------------------------------------------------------------
    |
    | This option allows you to add additional Artisan commands that should
    | be available within the Tinker environment. Once the command is in
    | this array you may execute the command in Tinker using its name.
    |
    */

    'commands' => [
        App\Console\Commands\PermanentlyAutoDeleteBrandCommand::class,
        App\Console\Commands\PermanentlyAutoDeleteCampaignBannerCommand::class,
        App\Console\Commands\PermanentlyAutoDeleteCategoryCommand::class,
        App\Console\Commands\PermanentlyAutoDeleteProductBannerCommand::class,
        App\Console\Commands\PermanentlyAutoDeleteSliderBannerCommand::class,
        App\Console\Commands\PermanentlyAutoDeleteSubCategoryCommand::class,
        App\Console\Commands\PermanentlyAutoDeleteProductCommand::class,
        App\Console\Commands\PermanentlyAutoDeleteInactiveVendorCommand::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Auto Aliased Classes
    |--------------------------------------------------------------------------
    |
    | Tinker will not automatically alias classes in your vendor namespaces
    | but you may explicitly allow a subset of classes to get aliased by
    | adding the names of each of those classes to the following list.
    |
    */

    'alias' => [
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | Classes That Should Not Be Aliased
    |--------------------------------------------------------------------------
    |
    | Typically, Tinker automatically aliases classes as you require them in
    | Tinker. However, you may wish to never alias certain classes, which
    | you may accomplish by listing the classes in the following array.
    |
    */

    'dont_alias' => [
        'App\Nova',
        App\Models\Brand::class,
        App\Models\CampaignBanner::class,
        App\Models\Category::class,
        App\Models\Color::class,
        App\Models\Image::class,
        App\Models\Product::class,
        App\Models\ProductBanner::class,
        App\Models\Size::class,
        App\Models\SliderBanner::class,
        App\Models\SubCategory::class,
        App\Models\User::class,

    ],

];
