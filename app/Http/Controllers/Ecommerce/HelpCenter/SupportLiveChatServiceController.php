<?php

namespace App\Http\Controllers\Ecommerce\HelpCenter;

use App\Http\Controllers\Controller;
use Inertia\Response;
use Inertia\ResponseFactory;

class SupportLiveChatServiceController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        return inertia("Ecommerce/HelpCenter/LiveChat/Index");
    }
}
