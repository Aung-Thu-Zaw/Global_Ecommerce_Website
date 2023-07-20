<?php

namespace App\Http\Controllers\Ecommerce\WebsitePages;

use App\Http\Controllers\Controller;
use Inertia\Response;
use Inertia\ResponseFactory;

class OurHistoryController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        return inertia("Ecommerce/WebsitePages/OurHistory/Index");
    }
}
