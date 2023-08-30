<?php

namespace App\Http\Controllers\Admin\ReviewManagements;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use App\Models\ShopReview;
use App\Actions\Admin\ReviewManagements\ShopReviews\PermanentlyDeleteAllTrashShopReviewAction;
use App\Http\Traits\HandlesQueryStringParameters;
use App\Services\BroadcastNotifications\AdminPublishedShopReviewNotificationNotificationSendToSellerDashboardService;

class AdminShopReviewController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $shopReviews = ShopReview::search(request("search"))
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

        $queryStringParams = $this->getQueryStringParams($request);

        return inertia("Admin/ReviewManagements/ShopReviews/Detail", compact("shopReview", "queryStringParams"));
    }

    public function update(Request $request, ShopReview $shopReview): RedirectResponse
    {
        $shopReview->update(["status" => $request->status]);

        if($request->status === "published") {
            (new AdminPublishedShopReviewNotificationNotificationSendToSellerDashboardService())->send($shopReview);
        }

        $message = $request->status === "unpublished" ? "SHOP_REVIEW_HAS_BEEN_SUCCESSFULLY_UNPUBLISHED" : "SHOP_REVIEW_HAS_BEEN_SUCCESSFULLY_PUBLISHED";

        return to_route('admin.shop-reviews.index', $this->getQueryStringParams($request))->with("success", $message);
    }

    public function destroy(Request $request, ShopReview $shopReview): RedirectResponse
    {
        $shopReview->delete();

        return to_route('admin.shop-reviews.index', $this->getQueryStringParams($request))->with("success", "SHOP_REVIEW_HAS_BEEN_SUCCESSFULLY_DELETED");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashShopReviews = ShopReview::search(request("search"))
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

        return to_route('admin.shop-reviews.trash', $this->getQueryStringParams($request))->with("success", "SHOP_REVIEW_HAS_BEEN_SUCCESSFULLY_RESTORED");
    }

    public function forceDelete(Request $request, int $trashShopReviewId): RedirectResponse
    {
        $trashShopReview = ShopReview::onlyTrashed()->findOrFail($trashShopReviewId);

        $trashShopReview->forceDelete();

        return to_route('admin.shop-reviews.trash', $this->getQueryStringParams($request))->with("success", "THE_SHOP_REVIEW_HAS_BEEN_PERMANENTLY_DELETED");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashShopReviews = ShopReview::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashShopReviewAction())->handle($trashShopReviews);

        return to_route('admin.shop-reviews.trash', $this->getQueryStringParams($request))->with("success", "SHOP_REVIEWS_HAVE_BEEN_PERMANENTLY_DELETED");
    }
}
