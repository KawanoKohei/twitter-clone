<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Follower;
use Illuminate\Auth\Access\HandlesAuthorization;

class FollowerPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 自分自身へのフォローを防ぐ
     *
     * @param User $user
     * @param Follower $follow
     * @return bool
     */
    public function follow(User $user, Follower $follow):bool
    {
        return $user->id !== $follow->followed_id;
    }
}
