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
     * @param integer $id
     * @param integer $loginUserId
     * @return boolean
     */
    public function isFollowing(int $loginUserId, int $id ): bool
    {
        return Follower::where('following_id', $loginUserId)->where('followed_id', $id)->exists();
    }
}
