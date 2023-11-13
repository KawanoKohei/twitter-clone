<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Favorite extends Model
{
    use HasFactory;

    protected $guarded = ['user_id', 'tweet_id'];
    
    /**
     * 既存いいねの確認
     *
     * @param integer $userId
     * @param integer $favoriteTweetId
     * @return boolean
     */
    public function isFavorite(int $favoriteTweetId ): bool
    {
        return Favorite::where('user_id', Auth::id())
            ->where('tweet_id', $favoriteTweetId)
            ->exists();
    }

    /**
     * いいねツイートID取得
     *
     * @return Collection
     */
    public function getAllByUserId(): Collection
    {
        return Favorite::query()
            ->where('user_id', Auth::id())
            ->pluck('tweet_id');
    }
}
