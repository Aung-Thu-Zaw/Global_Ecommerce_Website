<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqSubCategory;
use Inertia\Response;
use Inertia\ResponseFactory;

class HelpCenterController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $topQuestions=Faq::select("id", "question", "slug")
                         ->orderBy("helpful", "desc")
                         ->take(9)
                         ->get();

        $faqSubCategories=FaqSubCategory::select("id", "icon", "name", "slug")->get();

        return inertia("Ecommerce/HelpCenter/Index", compact("topQuestions", "faqSubCategories"));
    }

    public function searchResult(): Response|ResponseFactory
    {
        $faqs=Faq::filterBy(request(["search_question"]))
                 ->orderBy("id", "desc")
                 ->paginate(15)
                 ->withQueryString();

        return inertia("Ecommerce/HelpCenter/QuestionSearchResult", compact("faqs"));
    }
}
