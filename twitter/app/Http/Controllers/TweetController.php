<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTweetRequest;
use App\Http\Requests\SearchWordRequest;
use App\Http\Requests\UpdateTweetRequest;
use App\Models\Favorite;
use App\Models\Tweet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class TweetController extends Controller
{
    /**
     * ツイート投稿ページ表示
     *
     * @return View
     */
    public function tweet():View
    {
        return view('tweet.create');
    }
    
    /**
     * ツイート投稿作成機能
     *
     * @param CreateTweetRequest $request
     * @param Tweet $tweet
     * @return RedirectResponse
     */
    public function create(CreateTweetRequest $request, Tweet $tweet):RedirectResponse
    {
        $tweet->tweet = $request->tweet;
        $tweet->user_id = Auth::id();
        $tweet->create();

        return redirect()->route('tweet.index');
    }

    /**
     * ツイート一覧表示
     *
     * @return View
     */
    public function index(Favorite $favorite, Tweet $tweet):View
    {
        $tweets = $tweet->index();
        
        return view('tweet.index',compact('tweets', 'favorite'));
    }

    /**
     * ツイート詳細表示
     *
     * @param Tweet $tweet
     * @return View
     */
    public function detail(Tweet $tweet, Favorite $favorite):View
    {
        $tweet->detail($tweet->id);
        $replies = $tweet->replyIndex();
        // dd($replies);

        return view('tweet.show', compact('tweet','favorite', 'replies'));
    }

    /**
     * ツイート編集画面の表示
     *
     * @param int $tweetId
     * @param Tweet $tweet
     * @return View|RedirectResponse
     */
    public function edit(Tweet $tweet):View|RedirectResponse
    {
        if (Auth::id() === $tweet->user_id) {
            $tweet->detail($tweet->id);

            return view('tweet.edit', compact('tweet'));
        } else {
            return redirect()->route('tweet.detail', $tweet)->with('message', '他のユーザーのツイートを編集できません！！！');
        };
    }

    /**
     * ツイート編集
     *
     * @param UpdateTweetRequest $request
     * @param Tweet $tweet
     * @return RedirectResponse
     *  
     */
    public function update(UpdateTweetRequest $request, Tweet $tweet):RedirectResponse
    {
        try {
            $this->authorize('update',$tweet); 
            DB::beginTransaction();
            $tweet->tweet = $request->tweet;
            $tweet->updateTweet();
            DB::commit();

            return redirect()->route('tweet.detail', $tweet)->with('success', '更新しました！');
        } catch(\Exception $e) {
            Log::error($e);
            DB::rollback();
            
            return redirect()->route('tweet.detail', $tweet)->with('error', '更新中にエラーが発生しました！');
        }
    }

    /**
     * ツイートの削除
     *
     * @param Tweet $tweet
     * @return RedirectResponse
     */
    public function delete(Tweet $tweet):RedirectResponse
    {
        try {
            $this->authorize('delete',$tweet);
            $tweet->deleteByTweetId();

            return redirect()->route('tweet.index')->with('success', '削除しました！');
        } catch(\Exception $e) {
            Log::error($e);
            
            return redirect()->route('tweet.index')->with('error', '削除に失敗しました！');
        }
    }

    /**
     * クエリ検索機能
     *
     * @param Tweet $tweet
     * @param SearchWordRequest $request
     * @return View|RedirectResponse
     */
    public function searchByQuery(SearchWordRequest $request, Tweet $tweet, Favorite $favorite):View|RedirectResponse
    {
        try {
            $searchWord = $request->input('searchWord');
            //複数単語処理
            $spaceConversion = mb_convert_kana($searchWord, 's');
            $wordArraySearchWord = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);
            $tweets = $tweet->searchByQuery($wordArraySearchWord);

            return view('tweet.index',compact('tweets','favorite'));
        } catch(\Exception $e) {
            Log::error($e);
            
            return redirect()->route('tweet.index')->with('error', '検索に失敗しました！');
        }
    }

    /**
     * いいねしたツイート取得
     *
     * @param Favorite $favorite
     * @param Tweet $tweet
     * @return View
     */
    public function getAllFavoriteTweet(Favorite $favorite, Tweet $tweet):View
    {
        $tweetIds = $favorite->getAllByUserId();
        $tweetIdsArray = $tweetIds->toArray();
        $tweets = $tweet->getAllByTweetIds($tweetIdsArray);

        return view('tweet.favorite',compact('tweets', 'favorite'));
    }
}
