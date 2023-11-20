<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Follower;
use App\Http\Requests\UpdateReplyRequest;
use App\Models\Reply;
use App\Models\Tweet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ReplyController extends Controller
{
    /**
     * リプライの保存
     *
     * @param Request $request
     * @param Tweet $tweet
     * @param Reply $reply
     * @return RedirectResponse
     */
    public function store(Request $request, Tweet $tweet, Reply $reply): RedirectResponse
    {
        try {
            $reply->user_id = Auth::id();
            $reply->tweet_id = $tweet->id;
            $reply->reply = $request->replyMessage;
    
            $reply->store();
    
            return back();
        } catch(\Exception $e) {
            Log::error($e);

            return back()->with('error', 'いいね解除できませんでした！');
        }
    }

    /**
     * リプライ編集画面表示
     *
     * @param Reply $reply
     * @return View
     */
    public function edit(Reply $reply): View
    {
        return view('reply.edit', compact('reply'));
    }
    
    /**
     * リプライ編集
     *
     * @param Reply $reply
     * @param UpdateReplyRequest $request
     * @return RedirectResponse
     */
    public function update(Reply $reply, UpdateReplyRequest $request): RedirectResponse
    {
        try {
            $this->authorize('update',$reply);

            $reply->reply = $request->reply;
            $reply->replyUpdate();

            return redirect()->route('tweet.detail', $reply->tweet_id);
        } catch(\Exception $e) {
            Log::error($e);

            return back()->with('error', 'リプライ編集できませんでした！');
        }
    }

    /**
     * リプライ削除
     *
     * @param Reply $reply
     * @return RedirectResponse
     */
    public function delete(Reply $reply): RedirectResponse
    {
        try {
            $this->authorize('delete',$reply);
            $reply->replyDelete();

            return back();
        } catch(\Exception $e) {
            Log::error($e);

            return back()->with('error', '削除できませんでした！');
        }
    }
}
