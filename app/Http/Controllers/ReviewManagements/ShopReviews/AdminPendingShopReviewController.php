<?php

namespace App\Http\Controllers\ReviewManagements\ShopReviews;

use App\Http\Controllers\Controller;
use App\Models\ShopReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;

class AdminPendingShopReviewController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $pendingShopReviews=ShopReview::search(request("search"))
                                      ->query(function (Builder $builder) {
                                          $builder->with(["shop:id,shop_name","user:id,name"]);
                                      })
                                      ->where("status", 0)
                                      ->orderBy(request("sort", "id"), request("direction", "desc"))
                                      ->paginate(request("per_page", 10))
                                      ->appends(request()->all());

        return inertia("Admin/ReviewManagements/ShopReviews/PendingReviews/Index", compact("pendingShopReviews"));
    }

    public function show(Request $request, ShopReview $shopReview): Response|ResponseFactory
    {
        $shopReview->load(["shop:id,shop_name","user:id,name,email"]);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Admin/ReviewManagements/ShopReviews/PendingReviews/Details", compact("shopReview", "queryStringParams"));
    }

    public function update(Request $request, ShopReview $shopReview): RedirectResponse
    {
        $shopReview->update(["status"=>true]);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.shop-reviews.pending.index', $queryStringParams)->with("success", "Shop review has been successfully published.");
    }

    public function destroy(Request $request, ShopReview $shopReview): RedirectResponse
    {
        $shopReview->delete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.shop-reviews.pending.index', $queryStringParams)->with("success", "The shop review has been successfully moved to the trash.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashPendingShopReviews=ShopReview::search(request("search"))
                                           ->query(function (Builder $builder) {
                                               $builder->with(["shop:id,shop_name","user:id,name"]);
                                           })
                                           ->onlyTrashed()
                                           ->where("status", 0)
                                           ->orderBy(request("sort", "id"), request("direction", "desc"))
                                           ->paginate(request("per_page", 10))
                                           ->appends(request()->all());

        return inertia("Admin/ReviewManagements/ShopReviews/PendingReviews/Trash", compact("trashPendingShopReviews"));
    }

    public function restore(Request $request, int $trashShopReview): RedirectResponse
    {
        $pendingShopReview = ShopReview::onlyTrashed()->findOrFail($trashShopReview);

        $pendingShopReview->restore();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.shop-reviews.pending.trash', $queryStringParams)->with("success", "Shop review has been successfully restored.");
    }

    public function forceDelete(Request $request, int $trashShopReview): RedirectResponse
    {
        $pendingShopReview = ShopReview::onlyTrashed()->findOrFail($trashShopReview);

        $pendingShopReview->forceDelete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.shop-reviews.pending.trash', $queryStringParams)->with("success", "Shop review has been successfully deleted.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $pendingShopReviews = ShopReview::onlyTrashed()->get();

        $pendingShopReviews->each(function ($pendingShopReview) {

            $pendingShopReview->forceDelete();

        });

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.shop-reviews.pending.trash', $queryStringParams)->with("success", "Shop reviews have been successfully deleted.");
    }
}
