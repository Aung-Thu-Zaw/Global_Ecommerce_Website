<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Products\CreateProductAction;
use App\Actions\Admin\Products\UpdateProductAction;
use App\Actions\Products\PermanentlyDeleteAllTrashProductAction;
use App\Actions\Products\PermanentlyDeleteTrashProductAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Traits\HandlesQueryStringParameters;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\User;
use App\Services\BroadcastNotifications\CreatedNewProductApprovedOrDisapprovedNotificationSendToSellerDashboardService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminProductController extends Controller
{
    use HandlesQueryStringParameters;

    public function __construct()
    {
        $this->middleware('permission:products.view', ['only' => ['index']]);
        $this->middleware('permission:products.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:products.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:products.delete', ['only' => ['destroy', 'destroySelected']]);
        $this->middleware('permission:products.view.trash', ['only' => ['trashed']]);
        $this->middleware('permission:products.restore', ['only' => ['restore', 'restoreSelected']]);
        $this->middleware('permission:products.force.delete', ['only' => ['forceDelete', 'forceDeleteSelected', 'forceDeleteAll']]);
    }

    public function index(): Response|ResponseFactory
    {
        $products = Product::search(request('search'))
                           ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                           ->paginate(request('per_page', 10))
                           ->appends(request()->all());

        return inertia('Admin/Products/Index', compact('products'));
    }

    public function create(): Response|ResponseFactory
    {
        $brands = Brand::select("id", "name")->get();

        $categories = Category::select("id", "name")->get();

        $collections = Collection::select("id", "name")->get();

        $sellers = User::select('id', 'name', 'shop_name')->where([['status', 'active'], ['role', 'seller']])->get();

        return inertia('Admin/Products/Create', compact('brands', 'categories', 'collections', 'sellers'));
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        (new CreateProductAction())->handle($request->validated());

        return to_route('admin.products.index', $this->getQueryStringParams($request))->with('success', ':label has been successfully created.');
    }

    public function edit(Request $request, Product $product): Response|ResponseFactory
    {
        $brands = Brand::select("id", "name")->get();

        $categories = Category::select("id", "name")->get();

        $collections = Collection::select("id", "name")->get();

        $sellers = User::select('id', 'name', 'shop_name')->where([['status', 'active'], ['role', 'seller']])->get();

        $product->load(['sizes', 'colors', 'types', 'images']);

        return inertia('Admin/Products/Edit', compact('product', 'brands', 'categories', 'collections', 'sellers'));
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        (new UpdateProductAction())->handle($request->validated(), $product);

        return to_route('admin.products.index', $this->getQueryStringParams($request))->with('success', ':label has been successfully updated.');
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $product->delete();

        return to_route('admin.products.index', $this->getQueryStringParams($request))->with('success', ':label has been successfully deleted.');
    }


    public function destroySelected(Request $request): RedirectResponse
    {
        if (!empty($request->selectedItems)) {
            Product::whereIn('id', $request->selectedItems)->delete();
        }

        return to_route('admin.products.index', $this->getQueryStringParams($request))->with('success', 'Selected :label have been successfully deleted.');
    }

    public function trashed(): Response|ResponseFactory
    {
        $trashedProducts = Product::search(request('search'))
                                ->onlyTrashed()
                                ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                                ->paginate(request('per_page', 10))
                                ->appends(request()->all());

        return inertia('Admin/Products/Trash', compact('trashedProducts'));
    }

    public function restore(Request $request, int $trashProductId): RedirectResponse
    {
        $trashProduct = Product::onlyTrashed()->findOrFail($trashProductId);

        $trashProduct->restore();

        return to_route('admin.products.trash', $this->getQueryStringParams($request))->with('success', ':label has been successfully restored.');
    }


    public function restoreSelected(Request $request): RedirectResponse
    {
        if (!empty($request->selectedItems)) {
            Product::onlyTrashed()->whereIn('id', $request->selectedItems)->restore();
        }

        return to_route('admin.products.trashed', $this->getQueryStringParams($request))->with('success', 'Selected :label have been successfully restored.');
    }

    public function forceDelete(Request $request, int $trashProductId): RedirectResponse
    {
        $trashProduct = Product::onlyTrashed()->findOrFail($trashProductId);

        (new PermanentlyDeleteTrashProductAction())->handle($trashProduct);

        return to_route('admin.products.trash', $this->getQueryStringParams($request))->with('success', 'THE_PRODUCT_HAS_BEEN_PERMANENTLY_DELETED');
    }

    public function forceDeleteSelected(Request $request): RedirectResponse
    {
        if (!empty($request->selectedItems)) {
            Product::onlyTrashed()->whereIn('id', $request->selectedItems)->forceDelete();
        }

        return to_route('admin.products.trashed', $this->getQueryStringParams($request))->with('success', 'Selected :label have been permanently deleted.');
    }

    public function forceDeleteAll(Request $request): RedirectResponse
    {
        $trashProducts = Product::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashProductAction())->handle($trashProducts);

        return to_route('admin.products.trashed', $this->getQueryStringParams($request))->with('success', 'All :label have been permanently deleted.');
    }

    // public function handleStatus(Request $request, Product $product): RedirectResponse
    // {
    //     $product->update(['status' => $request->status]);

    //     (new CreatedNewProductApprovedOrDisapprovedNotificationSendToSellerDashboardService())->send($product);

    //     $message = $request->status === 'disapproved' ? 'PRODUCT_HAS_BEEN_SUCCESSFULLY_DISAPPROVED' : 'PRODUCT_HAS_BEEN_SUCCESSFULLY_APPROVED';

    //     return to_route('admin.products.index', $this->getQueryStringParams($request))->with('success', $message);
    // }
}
