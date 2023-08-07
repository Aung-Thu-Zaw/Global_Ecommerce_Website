<?php

namespace App\Http\Controllers\Admin\ReviewManagements;

use App\Actions\Admin\ReviewManagements\ShopReviews\PermanentlyDeleteAllTrashShopReviewAction;
use App\Http\Controllers\Controller;
use App\Models\ShopReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;

class AdminShopReviewController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $shopReviews=ShopReview::search(request("search"))
                                      ->query(function (Builder $builder) {
                                          $builder->with(["shop:id,shop_name"]);
                                      })
                                      ->orderBy(request("sort", "id"), request("direction", "desc"))
                                      ->paginate(request("per_page", 10))
                                      ->appends(request()->all());

        return inertia("Admin/ReviewManagements/ShopReviews/Index", compact("shopReviews"));
    }

    public function show(Request $request, ShopReview $shopReview): Response|ResponseFactory
    {
        $shopReview->load(["shop:id,shop_name","user:id,name,email"]);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Admin/ReviewManagements/ShopReviews/Details", compact("shopReview", "queryStringParams"));
    }

    public function update(Request $request, ShopReview $shopReview): RedirectResponse
    {
        $shopReview->update(["status"=>$request->status]);

        $message=$request->status==="unpublished" ? "Shop review has been successfully unpublished" : "Shop review has been successfully published";

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.shop-reviews.index', $queryStringParams)->with("success", $message);
    }

    public function destroy(Request $request, ShopReview $shopReview): RedirectResponse
    {
        $shopReview->delete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.shop-reviews.index', $queryStringParams)->with("success", "The shop review has been successfully moved to the trash.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashShopReviews=ShopReview::search(request("search"))
                                           ->query(function (Builder $builder) {
                                               $builder->with(["shop:id,shop_name"]);
                                           })
                                           ->onlyTrashed()
                                           ->orderBy(request("sort", "id"), request("direction", "desc"))
                                           ->paginate(request("per_page", 10))
                                           ->appends(request()->all());

        return inertia("Admin/ReviewManagements/ShopReviews/Trash", compact("trashShopReviews"));
    }

    public function restore(Request $request, int $trashShopReviewId): RedirectResponse
    {
        $trashShopReview = ShopReview::onlyTrashed()->findOrFail($trashShopReviewId);

        $trashShopReview->restore();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.shop-reviews.trash', $queryStringParams)->with("success", "Shop review has been successfully restored.");
    }

    public function forceDelete(Request $request, int $trashShopReviewId): RedirectResponse
    {
        $trashShopReview = ShopReview::onlyTrashed()->findOrFail($trashShopReviewId);

        $trashShopReview->forceDelete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.shop-reviews.trash', $queryStringParams)->with("success", "Shop review has been successfully deleted.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashShopReviews = ShopReview::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashShopReviewAction())->handle($trashShopReviews);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.shop-reviews.trash', $queryStringParams)->with("success", "Shop reviews have been successfully deleted.");
    }
}
