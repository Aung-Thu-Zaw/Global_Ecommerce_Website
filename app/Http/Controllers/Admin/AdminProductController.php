<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Products\CreateProductAction;
use App\Actions\Products\PermanentlyDeleteAllTrashProductAction;
use App\Actions\Admin\Products\UpdateProductAction;
use App\Actions\Products\PermanentlyDeleteTrashProductAction;
use App\Services\BroadcastNotifications\CreatedNewProductApporvedOrDisapprovedNotificationSendToSellerDashboardService;
use App\Http\Traits\HandlesQueryStringParameters;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\User;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $products=Product::search(request("search"))
                         ->orderBy(request("sort", "id"), request("direction", "desc"))
                         ->paginate(request("per_page", 10))
                         ->appends(request()->all());

        return inertia("Admin/Products/Index", compact("products"));
    }

    public function show(Request $request, Product $product): Response|ResponseFactory
    {
        $product->load("brand:id,name", "shop:id,shop_name", "images", "colors", "sizes", "types");

        $queryStringParams=$this->getQueryStringParams($request);

        return inertia("Admin/Products/Details", compact("product", "queryStringParams"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        $brands=Brand::all();

        $categories=Category::all();

        $collections=Collection::all();

        $sellers=User::select("id", "name", "shop_name")->where([["status","active"],["role","seller"]])->get();

        return inertia("Admin/Products/Create", compact("per_page", "brands", "categories", "collections", "sellers"));
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        (new CreateProductAction())->handle($request->validated());

        return to_route("admin.products.index", $this->getQueryStringParams($request))->with("success", "PRODUCT_HAS_BEEN_SUCCESSFULLY_CREATED");
    }

    public function edit(Request $request, Product $product): Response|ResponseFactory
    {
        $brands=Brand::all();

        $categories=Category::all();

        $collections=Collection::all();

        $sellers=User::select("id", "name", "shop_name")->where([["status","active"],["role","seller"]])->get();

        $product->load(["sizes","colors","types","images"]);

        $queryStringParams=$this->getQueryStringParams($request);

        return inertia("Admin/Products/Edit", compact("product", "queryStringParams", "brands", "categories", "collections", "sellers"));
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        (new UpdateProductAction())->handle($request->validated(), $product);

        return to_route("admin.products.index", $this->getQueryStringParams($request))->with("success", "PRODUCT_HAS_BEEN_SUCCESSFULLY_UPDATED");
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $product->delete();

        return to_route("admin.products.index", $this->getQueryStringParams($request))->with("success", "PRODUCT_HAS_BEEN_SUCCESSFULLY_DELETED");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashProducts=Product::search(request("search"))
                              ->onlyTrashed()
                              ->orderBy(request("sort", "id"), request("direction", "desc"))
                              ->paginate(request("per_page", 10))
                              ->appends(request()->all());

        return inertia("Admin/Products/Trash", compact("trashProducts"));
    }

    public function restore(Request $request, int $trashProductId): RedirectResponse
    {
        $trashProduct = Product::onlyTrashed()->findOrFail($trashProductId);

        $trashProduct->restore();

        return to_route('admin.products.trash', $this->getQueryStringParams($request))->with("success", "PRODUCT_HAS_BEEN_SUCCESSFULLY_RESTORED");
    }

    public function forceDelete(Request $request, int $trashProductId): RedirectResponse
    {
        $trashProduct = Product::onlyTrashed()->findOrFail($trashProductId);

        (new PermanentlyDeleteTrashProductAction())->handle($trashProduct);

        return to_route('admin.products.trash', $this->getQueryStringParams($request))->with("success", "THE_PRODUCT_HAS_BEEN_PERMANENTLY_DELETED");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashProducts = Product::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashProductAction())->handle($trashProducts);

        return to_route('admin.products.trash', $this->getQueryStringParams($request))->with("success", "PRODUCTS_HAVE_BEEN_PERMANENTLY_DELETED");
    }

    public function handleStatus(Request $request, Product $product): RedirectResponse
    {
        $product->update(["status"=>$request->status]);

        (new CreatedNewProductApporvedOrDisapprovedNotificationSendToSellerDashboardService())->send($product);

        $message=$request->status==="disapproved" ? "PRODUCT_HAS_BEEN_SUCCESSFULLY_DISAPPROVED" : "PRODUCT_HAS_BEEN_SUCCESSFULLY_APPROVED";

        return to_route('admin.products.index', $this->getQueryStringParams($request))->with("success", $message);
    }
}
