<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\VendorDashboardGuide;
use Inertia\Response;
use Inertia\ResponseFactory;

class VendorDashboardGuideController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $vendorDashboardGuides=VendorDashboardGuide::all();

        return inertia("Vendor/Guide/Index", compact("vendorDashboardGuides"));
    }
}
