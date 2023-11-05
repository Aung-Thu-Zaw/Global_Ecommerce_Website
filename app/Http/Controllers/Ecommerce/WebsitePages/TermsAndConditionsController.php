<?php

namespace App\Http\Controllers\Ecommerce\WebsitePages;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Inertia\Response;
use Inertia\ResponseFactory;

class TermsAndConditionsController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $termsAndConditions = Page::findOrFail(2);

        return inertia('Ecommerce/WebsitePages/TermsAndConditions/Index', compact('termsAndConditions'));
    }
}
