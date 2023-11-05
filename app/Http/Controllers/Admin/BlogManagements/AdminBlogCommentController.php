<?php

namespace App\Http\Controllers\Admin\BlogManagements;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminBlogCommentController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $blogComments = BlogComment::search(request('search'))
                                   ->query(function (Builder $builder) {
                                       $builder->with(['user:id,name', 'blogPost:id,title']);
                                   })->orderBy(request('sort', 'id'), request('direction', 'desc'))
                                   ->paginate(request('per_page', 10))
                                   ->appends(request()->all());

        return inertia('Admin/BlogManagements/BlogComments/Index', compact('blogComments'));
    }
}
