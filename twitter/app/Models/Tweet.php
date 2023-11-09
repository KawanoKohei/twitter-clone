<?php

namespace App\Models;

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
     * ユーザーテーブルとのリレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * いいねテーブルを中間テーブルとするユーザーモデルとの多対多リレーション
     *
     * @return BelongsToMany
     */
    public function favoriteUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites', 'tweet_id', 'user_id')
            ->withPivot('created_at','updated_at');
    }

    /**
     * いいねテーブルとのリレーション
     *
     * @return HasMany
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
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
            ->withCount('favorites')
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
            ->withCount('favorites')
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
     * いいね機能
     *
     * @return void
     */
    public function favorite():void
    {
        $this->favoriteUsers()->attach(Auth::id());
    }

    /**
     * いいね解除機能
     *
     * @return void
     */
    public function unfavorite():void
    {
        $this->favoriteUsers()->detach(Auth::id());
    }
}
