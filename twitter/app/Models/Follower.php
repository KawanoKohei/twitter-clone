<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory;

    protected $fillable = ['following_id', 'followed_id'];

    /**
     * 既存フォローの確認
     *
     * @param integer $FollowingId
     * @param integer $followedId
     * @return boolean
     */
    public function isFollowing(int $FollowingId, int $followedId ): bool
    {
        return Follower::where('following_id', $FollowingId)->where('followed_id', $followedId)->exists();
    }
}
