<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use Inertia\Response;
use Inertia\ResponseFactory;

class BlogController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        return inertia("Ecommerce/Blogs/Index");
    }
}
