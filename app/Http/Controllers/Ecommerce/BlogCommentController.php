<?php

namespace App\Http\Controllers\Ecommerce;

use App\Actions\Ecommerce\Blogs\CreateBlogCommentAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCommentRequest;
use App\Models\BlogComment;
use Illuminate\Http\RedirectResponse;

class BlogCommentController extends Controller
{
    public function store(BlogCommentRequest $request): RedirectResponse
    {
        (new CreateBlogCommentAction())->handle($request->validated());

        return back();
    }


    public function update(BlogCommentRequest $request, BlogComment $blogComment): RedirectResponse
    {
        $blogComment->update(["comment" => $request->comment]);

        return back();
    }

    public function destroy(BlogComment $blogComment): RedirectResponse
    {
        $blogComment->delete();

        return back();
    }
}
