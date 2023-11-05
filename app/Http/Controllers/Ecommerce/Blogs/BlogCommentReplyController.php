<?php

namespace App\Http\Controllers\Ecommerce\Blogs;

use App\Actions\Ecommerce\Blogs\CreateBlogCommentReplyAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCommentReplyRequest;
use App\Models\BlogCommentReply;
use App\Services\BroadcastNotifications\BlogCommentReplyFromAuthorNotificationSendToUserService;
use Illuminate\Http\RedirectResponse;

class BlogCommentReplyController extends Controller
{
    public function store(BlogCommentReplyRequest $request): RedirectResponse
    {
        $blogCommentReply = (new CreateBlogCommentReplyAction())->handle($request->validated());

        (new BlogCommentReplyFromAuthorNotificationSendToUserService())->send($blogCommentReply);

        return back();
    }

    public function update(BlogCommentReplyRequest $request, BlogCommentReply $blogCommentReply): RedirectResponse
    {
        $blogCommentReply->update(['reply_text' => $request->reply_text]);

        return back();
    }

    public function destroy(BlogCommentReply $blogCommentReply): RedirectResponse
    {
        $blogCommentReply->delete();

        return back();
    }
}
