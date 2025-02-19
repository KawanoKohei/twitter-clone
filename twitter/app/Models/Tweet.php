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
use Illuminate\Support\Collection as SupportCollection;
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
     * リプライテーブルとのリレーション
     *
     * @return HasMany
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class);
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
     * @param int $userId
     * @return LengthAwarePaginator
     */
    public function index(int $userId):LengthAwarePaginator
    {
        return $this->with('user')
            ->withExists([ 'favorites' => function ($isFavorite) use ($userId) {
                $isFavorite->where('user_id', $userId);
            }]) 
            ->withCount('favorites')
            ->withCount('replies')
            ->orderBy('updated_at', 'desc')
            ->paginate(6);
    }
    
    /**
     * ツイート詳細表示
     *
     * @param int $userId
     * @param int $tweetId
     * @return Tweet
     */
    public function detail(int $userId, int $tweetId):Tweet
    {
        return $this->with('user')
            ->withExists([ 'favorites' => function ($isFavorite) use ($userId) {
                $isFavorite->where('user_id', $userId);
            }]) 
            ->withCount('favorites')
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
     * @param int $userId
     * @return void
     */
    public function favorite(int $userId):void
    {
        $this->favoriteUsers()->attach($userId);
    }

    /**
     * いいね解除機能
     *
     * @param int $userId
     * @return void
     */
    public function unfavorite(int $userId):void
    {
        $this->favoriteUsers()->detach($userId);
    }

    /**
     * いいねツイート取得
     *
     * @param int $userId
     * @param SupportCollection $tweetIds
     * @return LengthAwarePaginator
     */
    public function getAllByTweetIds(int $userId, SupportCollection $tweetIds):LengthAwarePaginator
    {
        return Tweet::query()
            ->whereIn('id', $tweetIds)
            ->with('user')
            ->withExists([ 'favorites' => function ($isFavorite) use ($userId) {
                $isFavorite->where('user_id', $userId);
            }]) 
            ->withCount('favorites')
            ->paginate(5);
    }

    /**
     * リプライ一覧機能
     *
     * @return Collection
     */
    public function getAllReply():Collection
    {
        return $this->replies()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
