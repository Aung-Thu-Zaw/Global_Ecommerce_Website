<?php

namespace App\Http\Controllers\Admin\ReviewManagements;

use App\Actions\Admin\ReviewManagements\ProductReviews\PermanentlyDeleteAllTrashProductReviewAction;
use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;

class AdminProductReviewController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $productReviews=ProductReview::search(request("search"))
                                            ->query(function (Builder $builder) {
                                                $builder->with(["product:id,name"]);
                                            })
                                            ->orderBy(request("sort", "id"), request("direction", "desc"))
                                            ->paginate(request("per_page", 10))
                                            ->appends(request()->all());

        return inertia("Admin/ReviewManagements/ProductReviews/Index", compact("productReviews"));
    }

    public function show(Request $request, ProductReview $productReview): Response|ResponseFactory
    {
        $productReview->load(["product:id,name","user:id,name,email"]);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Admin/ReviewManagements/ProductReviews/Details", compact("productReview", "queryStringParams"));
    }

    public function update(Request $request, ProductReview $productReview): RedirectResponse
    {
        $productReview->update(["status"=>$request->status]);

        $message=$request->status==="unpublished" ? "Product review has been successfully unpublished" : "Product review has been successfully published";

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.product-reviews.index', $queryStringParams)->with("success", $message);
    }

    public function destroy(Request $request, ProductReview $productReview): RedirectResponse
    {
        $productReview->delete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.product-reviews.index', $queryStringParams)->with("success", "The product review has been successfully moved to the trash.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashProductReviews=ProductReview::search(request("search"))
                                                 ->query(function (Builder $builder) {
                                                     $builder->with(["product:id,name"]);
                                                 })
                                                 ->onlyTrashed()
                                                 ->orderBy(request("sort", "id"), request("direction", "desc"))
                                                 ->paginate(request("per_page", 10))
                                                 ->appends(request()->all());

        return inertia("Admin/ReviewManagements/ProductReviews/Trash", compact("trashProductReviews"));
    }

    public function restore(Request $request, int $trashProductReview): RedirectResponse
    {
        $trashProductReview = ProductReview::onlyTrashed()->findOrFail($trashProductReview);

        $trashProductReview->restore();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.product-reviews.trash', $queryStringParams)->with("success", "Product review has been successfully restored.");
    }

    public function forceDelete(Request $request, int $trashProductReview): RedirectResponse
    {
        $trashProductReview = ProductReview::onlyTrashed()->findOrFail($trashProductReview);

        $trashProductReview->forceDelete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.product-reviews.trash', $queryStringParams)->with("success", "Product review has been successfully deleted.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashProductReviews = ProductReview::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashProductReviewAction())->handle($trashProductReviews);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.product-reviews.trash', $queryStringParams)->with("success", "Product reviews have been successfully deleted.");
    }
}
