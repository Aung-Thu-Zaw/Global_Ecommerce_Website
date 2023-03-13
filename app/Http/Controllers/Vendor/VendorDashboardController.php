<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class VendorDashboardController extends Controller
{
    public function index(): Response
    {
        return inertia("Vendor/Dashboard");
    }
}
