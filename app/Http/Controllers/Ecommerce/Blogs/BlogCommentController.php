<?php

namespace App\Http\Controllers\Ecommerce\Blogs;

use App\Actions\Ecommerce\Blogs\CreateBlogCommentAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCommentRequest;
use App\Models\BlogComment;
use App\Services\BroadcastNotifications\NewBlogCommentNotificationSendToAdminDashboardService;
use Illuminate\Http\RedirectResponse;

class BlogCommentController extends Controller
{
    public function store(BlogCommentRequest $request): RedirectResponse
    {
        $blogComment = (new CreateBlogCommentAction())->handle($request->validated());

        (new NewBlogCommentNotificationSendToAdminDashboardService())->send($blogComment);

        return back();
    }

    public function update(BlogCommentRequest $request, BlogComment $blogComment): RedirectResponse
    {
        $blogComment->update(['comment' => $request->comment]);

        return back();
    }

    public function destroy(BlogComment $blogComment): RedirectResponse
    {
        $blogComment->delete();

        return back();
    }
}
