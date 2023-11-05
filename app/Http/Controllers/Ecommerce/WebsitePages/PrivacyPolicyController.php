<?php

namespace App\Http\Controllers\Ecommerce\WebsitePages;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Inertia\Response;
use Inertia\ResponseFactory;

class PrivacyPolicyController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $privacyPolicy = Page::findOrFail(1);

        return inertia('Ecommerce/WebsitePages/PrivacyPolicy/Index', compact('privacyPolicy'));
    }
}
