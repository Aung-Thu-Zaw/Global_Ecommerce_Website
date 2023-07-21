<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use Inertia\Response;
use Inertia\ResponseFactory;

class HelpCenterController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        return inertia("Ecommerce/HelpCenter/Index");
    }
}
