<?php

namespace App\Http\Controllers\Ecommerce\WebsitePages;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use Inertia\Response;
use Inertia\ResponseFactory;

class FaqController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $faqCategories=FaqCategory::with("faqSubCategories")->get();

        $faqs=Faq::orderBy("id", "desc")->paginate(15);

        return inertia("Ecommerce/WebsitePages/Faqs/Index", compact("faqCategories", "faqs"));
    }

    public function show(Faq $faq): Response|ResponseFactory
    {
        $faq->load(["faqSubCategory.faqCategory"]);

        $faqCategories=FaqCategory::with("faqSubCategories")->get();

        $relatedFaqs=Faq::where("faq_sub_category_id", $faq->faq_sub_category_id)->where("slug", "!=", $faq->slug)->take(5)->get();

        // $faqs=Faq::orderBy("id", "desc")->paginate(15);

        return inertia("Ecommerce/WebsitePages/Faqs/Details", compact("faqCategories", "faq", "relatedFaqs"));
    }
}
