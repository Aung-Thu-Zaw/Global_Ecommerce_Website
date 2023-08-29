<?php

namespace App\Http\Controllers\Admin\ReviewManagements;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use App\Models\ProductReview;
use App\Actions\Admin\ReviewManagements\ProductReviews\PermanentlyDeleteAllTrashProductReviewAction;
use App\Actions\Admin\ReviewManagements\ProductReviews\PermanentlyDeleteTrashProductReviewAction;
use App\Http\Traits\HandlesQueryStringParameters;
use App\Services\BroadcastNotifications\AdminPublishedProductReviewNotificationNotificationSendToSellerDashboardService;

class AdminProductReviewController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $productReviews = ProductReview::search(request("search"))
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
        $productReview->load(["product:id,name","user:id,name,email","images"]);

        $queryStringParams = $this->getQueryStringParams($request);

        return inertia("Admin/ReviewManagements/ProductReviews/Detail", compact("productReview", "queryStringParams"));
    }

    public function update(Request $request, ProductReview $productReview): RedirectResponse
    {
        $productReview->update(["status" => $request->status]);

        if($request->status === "published") {
            (new AdminPublishedProductReviewNotificationNotificationSendToSellerDashboardService())->send($productReview);
        }

        $message = $request->status === "unpublished" ? "PRODUCT_REVIEW_HAS_BEEN_SUCCESSFULLY_UNPUBLISHED" : "PRODUCT_REVIEW_HAS_BEEN_SUCCESSFULLY_PUBLISHED";

        return to_route('admin.product-reviews.index', $this->getQueryStringParams($request))->with("success", $message);
    }

    public function destroy(Request $request, ProductReview $productReview): RedirectResponse
    {
        $productReview->delete();

        return to_route('admin.product-reviews.index', $this->getQueryStringParams($request))->with("success", "PRODUCT_REVIEW_HAS_BEEN_SUCCESSFULLY_DELETED");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashProductReviews = ProductReview::search(request("search"))
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

        return to_route('admin.product-reviews.trash', $this->getQueryStringParams($request))->with("success", "PRODUCT_REVIEW_HAS_BEEN_SUCCESSFULLY_RESTORED");
    }

    public function forceDelete(Request $request, int $trashProductReview): RedirectResponse
    {
        $trashProductReview = ProductReview::onlyTrashed()->findOrFail($trashProductReview);

        $trashProductReview->forceDelete();

        (new PermanentlyDeleteTrashProductReviewAction())->handle($trashProductReview);

        return to_route('admin.product-reviews.trash', $this->getQueryStringParams($request))->with("success", "THE_PRODUCT_REVIEW_HAS_BEEN_PERMANENTLY_DELETED");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashProductReviews = ProductReview::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashProductReviewAction())->handle($trashProductReviews);

        return to_route('admin.product-reviews.trash', $this->getQueryStringParams($request))->with("success", "PRODUCT_REVIEWS_HAVE_BEEN_PERMANENTLY_DELETED");
    }
}
