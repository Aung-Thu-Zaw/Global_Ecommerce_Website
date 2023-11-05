<?php

namespace App\Http\Controllers\Admin\BlogManagements;

use App\Actions\Admin\BlogManagements\BlogPosts\CreateBlogPostAction;
use App\Actions\Admin\BlogManagements\BlogPosts\PermanentlyDeleteAllTrashBlogPostAction;
use App\Actions\Admin\BlogManagements\BlogPosts\UpdateBlogPostAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogPostRequest;
use App\Http\Traits\HandlesQueryStringParameters;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminBlogPostController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $blogPosts = BlogPost::search(request('search'))
                             ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                             ->paginate(request('per_page', 10))
                             ->appends(request()->all());

        return inertia('Admin/BlogManagements/BlogPosts/Index', compact('blogPosts'));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page = request('per_page');

        $blogCategories = BlogCategory::all();

        return inertia('Admin/BlogManagements/BlogPosts/Create', compact('per_page', 'blogCategories'));
    }

    public function store(BlogPostRequest $request): RedirectResponse
    {
        (new CreateBlogPostAction())->handle($request->validated());

        return to_route('admin.blogs.posts.index', $this->getQueryStringParams($request))->with('success', 'BLOG_POST_HAS_BEEN_SUCCESSFULLY_CREATED');
    }

    public function edit(Request $request, BlogPost $blogPost): Response|ResponseFactory
    {
        $queryStringParams = $this->getQueryStringParams($request);

        $blogCategories = BlogCategory::all();

        $blogPost->load(['blogTags']);

        return inertia('Admin/BlogManagements/BlogPosts/Edit', compact('blogPost', 'queryStringParams', 'blogCategories'));
    }

    public function update(BlogPostRequest $request, BlogPost $blogPost): RedirectResponse
    {
        (new UpdateBlogPostAction())->handle($request->validated(), $blogPost);

        return to_route('admin.blogs.posts.index', $this->getQueryStringParams($request))->with('success', 'BLOG_POST_HAS_BEEN_SUCCESSFULLY_UPDATED');
    }

    public function destroy(Request $request, BlogPost $blogPost): RedirectResponse
    {
        $blogPost->delete();

        return to_route('admin.blogs.posts.index', $this->getQueryStringParams($request))->with('success', 'BLOG_POST_HAS_BEEN_SUCCESSFULLY_DELETED');
    }

    public function trash(): Response|ResponseFactory
    {
        $trashBlogPosts = BlogPost::search(request('search'))
                                  ->onlyTrashed()
                                  ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                                  ->paginate(request('per_page', 10))
                                  ->appends(request()->all());

        return inertia('Admin/BlogManagements/BlogPosts/Trash', compact('trashBlogPosts'));
    }

    public function restore(Request $request, int $trashBlogPostId): RedirectResponse
    {
        $trashBlogPost = BlogPost::onlyTrashed()->findOrFail($trashBlogPostId);

        $trashBlogPost->restore();

        return to_route('admin.blogs.posts.trash', $this->getQueryStringParams($request))->with('success', 'BLOG_POST_HAS_BEEN_SUCCESSFULLY_RESTORED');
    }

    public function forceDelete(Request $request, int $trashBlogPostId): RedirectResponse
    {
        $trashBlogPost = BlogPost::onlyTrashed()->findOrFail($trashBlogPostId);

        BlogPost::deleteImage($trashBlogPost->image);

        $trashBlogPost->forceDelete();

        return to_route('admin.blogs.posts.trash', $this->getQueryStringParams($request))->with('success', 'THE_BLOG_POST_HAS_BEEN_PERMANENTLY_DELETED');
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashBlogPosts = BlogPost::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashBlogPostAction())->handle($trashBlogPosts);

        return to_route('admin.blogs.posts.trash', $this->getQueryStringParams($request))->with('success', 'BLOG_POSTS_HAVE_BEEN_PERMANENTLY_DELETED');
    }
}
