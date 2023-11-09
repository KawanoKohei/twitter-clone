<?php

namespace App\Models;

use App\Models\Reply;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class Tweet extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Get the user that owns the Tweet
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * リプライテーブルとのリレーション
     *
     * @return HasMany
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * ツイート投稿作成機能
     *
     * @return void
     */
    public function create():void
    {
        $this->save();
    }

    /**
     * ツイート一覧の表示
     *
     * @return LengthAwarePaginator
     */
    public function index():LengthAwarePaginator
    {
        return $this->with('user')
            ->withCount('replies')
            ->orderBy('updated_at', 'desc')
            ->paginate(6);
    }
    
    /**
     * ツイート詳細表示
     *
     * @param int $tweetId
     * @return Tweet
     */
    public function detail(int $tweetId):Tweet
    {
        return $this->with('user')
            ->withCount('replies')
            ->find($tweetId);
    }

    /**
     * ツイートを更新
     *
     * @return void
     */
    public function updateTweet():void
    {
        $this->update();
    }

    /**
     * ツイート削除機能
     *
     * @return void
     */
    public function deleteByTweetId():void
    {
        $this->delete();
    }

    /**
     * ユーザーモデルとの多対多リレーション
     *
     * @return BelongsToMany
     */
    public function favoriteUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites', 'tweet_id', 'user_id');
    }

    /** 
     * クエリ検索機能
     *
     * @param array $wordArraySearchWord
     * @return LengthAwarePaginator
     */
    public function searchByQuery(array $wordArraySearchWord):LengthAwarePaginator
    {
        $searchWord = Tweet::query();

        foreach ($wordArraySearchWord as $word) {
            $searchWord->orWhere('tweet', 'like', '%'.$word.'%');
        }

        return $searchWord->with('user')
            ->orderBy('updated_at', 'desc')
            ->paginate(5);
    }

    /**
     * いいねツイート取得
     *
     * @param array $tweetIds
     * @return LengthAwarePaginator
     */
    public function getAllByTweetIds(array $tweetIds):LengthAwarePaginator
    {
        return Tweet::query()
            ->whereIn('id', $tweetIds)
            ->with('user')
            ->paginate(5);
    }

    public function replyIndex()
    {
        return $this->replies()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
