<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
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
     * リプライの編集におけるポリシー
     *
     * @param User $user
     * @param Reply $reply
     * @return boolean
     */
    public function update(User $user, Reply $reply):bool
    {
        return $user->id === $reply->user_id;
    }

    /**
     * リプライ削除におけるポリシー
     *
     * @param User $user
     * @param Reply $reply
     * @return boolean
     */
    public function delete(User $user, Reply $reply):bool
    {
        return $user->id === $reply->user_id;
    }
}
