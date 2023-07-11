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

    public function show(int $id): Response|ResponseFactory
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        $pendingProductReview=ProductReview::findOrFail($id);

        $pendingProductReview->load(["product:id,name","user:id,name,email"]);

        return inertia("Admin/ReviewManagements/ProductReviews/PendingReviews/Details", compact("pendingProductReview", "paginate"));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $pendingProductReview=ProductReview::findOrFail($id);

        $pendingProductReview->update(["status"=>true]);

        return to_route('admin.product-reviews.pending.index', "page=$request->page&per_page=$request->per_page")->with("success", "Product review has been successfully published.");
    }

    public function destroy(Request $request, int  $id): RedirectResponse
    {
        $pendingProductReview=ProductReview::findOrFail($id);

        $pendingProductReview->delete();

        return to_route('admin.product-reviews.pending.index', "page=$request->page&per_page=$request->per_page")->with("success", "The product review has been successfully moved to the trash.");
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

        return inertia("Admin/UserManagements/VendorManage/InactiveVendors/Trash", compact("trashPendingProductReviews"));
    }

    public function restore(Request $request, int $id): RedirectResponse
    {
        $pendingProductReview = ProductReview::onlyTrashed()->findOrFail($id);

        $pendingProductReview->restore();

        return to_route('admin.product-reviews.pending.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Product review has been successfully restored.");
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $pendingProductReview = ProductReview::onlyTrashed()->findOrFail($id);

        $pendingProductReview->forceDelete();

        return to_route('admin.product-reviews.pending.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Product review has been successfully deleted.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $pendingProductReviews = ProductReview::onlyTrashed()->get();

        $pendingProductReviews->each(function ($pendingProductReview) {
            $pendingProductReview->forceDelete();
        });

        return to_route('admin.product-reviews.pending.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Product reviews have been successfully deleted.");
    }
}
