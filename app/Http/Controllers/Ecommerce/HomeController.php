<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\CampaignBanner;
use App\Models\Category;
use App\Models\Collection;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Product;
use App\Models\ProductBanner;
use App\Models\SliderBanner;
use App\Models\WebsiteSetting;
use Inertia\Response;
use Inertia\ResponseFactory;

class HomeController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $categories = Category::with("children")->limit(8)->get();

        $collections = Collection::select("id", "title", "slug")
                               ->with("products:id,collection_id,image,status")
                               ->limit(12)
                               ->get();

        $sliderBanners = SliderBanner::select("id", "image", "url")
                                   ->whereStatus("show")
                                   ->orderBy("id", "desc")
                                   ->limit(6)
                                   ->get();

        $campaignBanner = CampaignBanner::select("id", "image", "url")
                                      ->whereStatus("show")
                                      ->first();

        $productBanners = ProductBanner::select("id", "image", "url")
                                     ->whereStatus("show")
                                     ->orderBy("id", "desc")
                                     ->limit(3)
                                     ->get();

        $flashSale = FlashSale::findOrFail(1);

        $flashSaleProducts = FlashSaleItem::with(["product:id,seller_id,image,name,slug,price,discount,special_offer","product.productReviews:id,product_id,rating","product.shop:id,offical"])
                                          ->orderBy("id", "desc")
                                          ->limit(5)
                                          ->get();


        $newProducts = Product::select("id", "seller_id", "image", "name", "slug", "price", "discount", "special_offer")
                            ->with(["productReviews:id,product_id,rating","shop:id,offical"])
                            ->whereStatus("approved")
                            ->orderBy("id", "desc")
                            ->limit(5)
                            ->get();

        $hotDealProducts = Product::select("id", "seller_id", "image", "name", "slug", "price", "discount", "special_offer")
                                ->with(["productReviews:id,product_id,rating","shop:id,offical"])
                                ->whereStatus("approved")
                                ->whereHotDeal(1)
                                ->orderBy("id", "desc")
                                ->limit(5)
                                ->get();

        $featuredProducts = Product::select("id", "seller_id", "image", "name", "slug", "price", "discount", "special_offer")
                                 ->with(["productReviews:id,product_id,rating","shop:id,offical"])
                                 ->whereStatus("approved")
                                 ->whereFeatured(1)
                                 ->orderBy("id", "desc")
                                 ->limit(5)
                                 ->get();

        $randomProducts = Product::select("id", "seller_id", "image", "name", "slug", "price", "discount", "special_offer")
                               ->with(["productReviews:id,product_id,rating","shop:id,offical"])
                               ->whereStatus("approved")
                               ->inRandomOrder()
                               ->paginate(25);

        $socialMedia = WebsiteSetting::select("id", "facebook", "twitter", "instagram", "youtube", "reddit", "linked_in")->first();

        return inertia('Ecommerce/Home/Index', compact(
            "categories",
            "collections",
            "sliderBanners",
            "campaignBanner",
            "productBanners",
            "flashSale",
            "newProducts",
            "featuredProducts",
            "hotDealProducts",
            "flashSaleProducts",
            "randomProducts",
            "socialMedia"
        ));
    }
}
