<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use Inertia\Response;
use Inertia\ResponseFactory;

class HelpCenterController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $topQuestions=Faq::select("id", "question", "slug")->orderBy("helpful", "desc")->take(9)->get();

        $faqCategories=FaqCategory::select("id", "name", "slug")->get();

        return inertia("Ecommerce/HelpCenter/Index", compact("topQuestions", "faqCategories"));
    }
}
