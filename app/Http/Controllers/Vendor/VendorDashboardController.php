<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Inertia\Response;
use Inertia\ResponseFactory;

class VendorDashboardController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        return inertia("Vendor/Dashboard");
    }
}
