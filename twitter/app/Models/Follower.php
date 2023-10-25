<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory;

    protected $fillable = ['following_id', 'followed_id'];

    /**
     * フォロー
     *
     * @return void
     */
    public function follow():void
    {
        $this->save();
    }

    /**
     * フォロー解除
     *
     * @param integer $id
     * @param integer $loginUserId
     * @return void
     */
    public function unfollow(int $loginUserId, int $id):void
    {
        $follow = Follower::where('following_id', $loginUserId)->where('followed_id', $id)->first();
        $follow->delete();
    }
}
