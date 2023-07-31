<?php

namespace App\Http\Controllers\ReviewManagements\ProductReviews;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;

class AdminPendingProductReviewController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $pendingProductReviews=ProductReview::search(request("search"))
                                            ->query(function (Builder $builder) {
                                                $builder->with(["product:id,name","user:id,name"]);
                                            })
                                            ->where("status", 0)
                                            ->orderBy(request("sort", "id"), request("direction", "desc"))
                                            ->paginate(request("per_page", 10))
                                            ->appends(request()->all());

        return inertia("Admin/ReviewManagements/ProductReviews/PendingReviews/Index", compact("pendingProductReviews"));
    }

    public function show(Request $request, ProductReview $productReview): Response|ResponseFactory
    {
        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        $productReview->load(["product:id,name","user:id,name,email"]);

        return inertia("Admin/ReviewManagements/ProductReviews/PendingReviews/Details", compact("productReview", "queryStringParams"));
    }

    public function update(Request $request, ProductReview $productReview): RedirectResponse
    {
        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        $productReview->update(["status"=>true]);

        return to_route('admin.product-reviews.pending.index', $queryStringParams)->with("success", "Product review has been successfully published.");
    }

    public function destroy(Request $request, ProductReview $productReview): RedirectResponse
    {
        $productReview->delete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.product-reviews.pending.index', $queryStringParams)->with("success", "The product review has been successfully moved to the trash.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashPendingProductReviews=ProductReview::search(request("search"))
                                                 ->query(function (Builder $builder) {
                                                     $builder->with(["product:id,name","user:id,name"]);
                                                 })
                                                 ->onlyTrashed()
                                                 ->where("status", 0)
                                                 ->orderBy(request("sort", "id"), request("direction", "desc"))
                                                 ->paginate(request("per_page", 10))
                                                 ->appends(request()->all());

        return inertia("Admin/ReviewManagements/ProductReviews/PendingReviews/Trash", compact("trashPendingProductReviews"));
    }

    public function restore(Request $request, int $trashProductReview): RedirectResponse
    {
        $pendingProductReview = ProductReview::onlyTrashed()->findOrFail($trashProductReview);

        $pendingProductReview->restore();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.product-reviews.pending.trash', $queryStringParams)->with("success", "Product review has been successfully restored.");
    }

    public function forceDelete(Request $request, int $trashProductReview): RedirectResponse
    {
        $pendingProductReview = ProductReview::onlyTrashed()->findOrFail($trashProductReview);

        $pendingProductReview->forceDelete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.product-reviews.pending.trash', $queryStringParams)->with("success", "Product review has been successfully deleted.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $pendingProductReviews = ProductReview::onlyTrashed()->get();

        $pendingProductReviews->each(function ($pendingProductReview) {

            $pendingProductReview->forceDelete();

        });

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.product-reviews.pending.trash', $queryStringParams)->with("success", "Product reviews have been successfully deleted.");
    }
}
