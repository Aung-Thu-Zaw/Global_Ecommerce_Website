<?php

namespace App\Http\Controllers\Admin\BlogManagements;

use App\Actions\Admin\BlogManagements\BlogCategories\CreateBlogCategoryAction;
use App\Actions\Admin\BlogManagements\BlogCategories\PermanentlyDeleteAllTrashBlogCategoryAction;
use App\Actions\Admin\BlogManagements\BlogCategories\UpdateBlogCategoryAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCategoryRequest;
use App\Http\Traits\HandlesQueryStringParameters;
use App\Models\BlogCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminBlogCategoryController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $blogCategories = BlogCategory::search(request('search'))
                                      ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                                      ->paginate(request('per_page', 10))
                                      ->appends(request()->all());

        return inertia('Admin/BlogManagements/BlogCategories/Index', compact('blogCategories'));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page = request('per_page');

        return inertia('Admin/BlogManagements/BlogCategories/Create', compact('per_page'));
    }

    public function store(BlogCategoryRequest $request): RedirectResponse
    {
        (new CreateBlogCategoryAction())->handle($request->validated());

        return to_route('admin.blogs.categories.index', $this->getQueryStringParams($request))->with('success', 'BLOG_CATEGORY_HAS_BEEN_SUCCESSFULLY_CREATED');
    }

    public function edit(Request $request, BlogCategory $blogCategory): Response|ResponseFactory
    {
        $queryStringParams = $this->getQueryStringParams($request);

        return inertia('Admin/BlogManagements/BlogCategories/Edit', compact('blogCategory', 'queryStringParams'));
    }

    public function update(BlogCategoryRequest $request, BlogCategory $blogCategory): RedirectResponse
    {
        (new UpdateBlogCategoryAction())->handle($request->validated(), $blogCategory);

        return to_route('admin.blogs.categories.index', $this->getQueryStringParams($request))->with('success', 'BLOG_CATEGORY_HAS_BEEN_SUCCESSFULLY_UPDATED');
    }

    public function destroy(Request $request, BlogCategory $blogCategory): RedirectResponse
    {
        $blogCategory->delete();

        return to_route('admin.blogs.categories.index', $this->getQueryStringParams($request))->with('success', 'BLOG_CATEGORY_HAS_BEEN_SUCCESSFULLY_DELETED');
    }

    public function trash(): Response|ResponseFactory
    {
        $trashBlogCategories = BlogCategory::search(request('search'))
                                           ->onlyTrashed()
                                           ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                                           ->paginate(request('per_page', 10))
                                           ->appends(request()->all());

        return inertia('Admin/BlogManagements/BlogCategories/Trash', compact('trashBlogCategories'));
    }

    public function restore(Request $request, int $trashBlogCategoryId): RedirectResponse
    {
        $trashBlogCategory = BlogCategory::onlyTrashed()->findOrFail($trashBlogCategoryId);

        $trashBlogCategory->restore();

        return to_route('admin.blogs.categories.trash', $this->getQueryStringParams($request))->with('success', 'BLOG_CATEGORY_HAS_BEEN_SUCCESSFULLY_RESTORED');
    }

    public function forceDelete(Request $request, int $trashBlogCategoryId): RedirectResponse
    {
        $trashBlogCategory = BlogCategory::onlyTrashed()->findOrFail($trashBlogCategoryId);

        BlogCategory::deleteImage($trashBlogCategory->image);

        $trashBlogCategory->forceDelete();

        return to_route('admin.blogs.categories.trash', $this->getQueryStringParams($request))->with('success', 'THE_BLOG_CATEGORY_HAS_BEEN_PERMANENTLY_DELETED');
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashBlogCategories = BlogCategory::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashBlogCategoryAction())->handle($trashBlogCategories);

        return to_route('admin.blogs.categories.trash', $this->getQueryStringParams($request))->with('success', 'BLOG_CATEGORIES_HAVE_BEEN_PERMANENTLY_DELETED');
    }
}
