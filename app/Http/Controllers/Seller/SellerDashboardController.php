<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Inertia\Response;
use Inertia\ResponseFactory;

class SellerDashboardController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        return inertia('Seller/Dashboard');
    }
}
