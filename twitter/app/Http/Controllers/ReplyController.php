<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Follower;
use App\Models\Reply;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ReplyController extends Controller
{
    /**
     * リプライの保存
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tweet $tweet, Reply $reply)
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
