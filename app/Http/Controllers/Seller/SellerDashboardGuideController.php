<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\SellerDashboardGuide;
use Inertia\Response;
use Inertia\ResponseFactory;

class SellerDashboardGuideController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $sellerDashboardGuides=SellerDashboardGuide::all();

        return inertia("Seller/Guide/Index", compact("sellerDashboardGuides"));
    }
}
