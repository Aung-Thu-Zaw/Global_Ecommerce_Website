<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\DeliveryInformation;
use App\Models\Product;
use App\Models\Region;
use App\Models\Township;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class BuyNowController extends Controller
{
    public function buyNow(string $productSlug): Response|ResponseFactory
    {

        $product = Product::with(["shop","brand","sizes","colors","types"])->where("slug", $productSlug)->first();

        $quantity = request("quantity");

        $countries = Country::all();
        $regions = Region::with("country")->get();
        $cities = City::with("region")->get();
        $townships = Township::with("city")->get();

        $deliveryInformation = DeliveryInformation::where("user_id", auth()->id())->first();

        $coupon = session("coupon") ?? "";

        return inertia("Ecommerce/Checkout/Index", compact("countries", "regions", "cities", "townships", "deliveryInformation", "coupon", "product", "quantity"));
    }
}
