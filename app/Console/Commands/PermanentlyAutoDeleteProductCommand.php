<?php

namespace App\Console\Commands;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PermanentlyAutoDeleteProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Products in the trash will be automatically deleted after 60 days';


    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(60);

        $products=Product::onlyTrashed()
                         ->where('deleted_at', '<=', $cutoffDate)
                         ->get();

        $products->each(function ($product) {

            Product::deleteImage($product);

            $product->forceDelete();

        });
    }
}
