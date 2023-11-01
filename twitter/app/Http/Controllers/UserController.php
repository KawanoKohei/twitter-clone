<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserEditRequest;
use App\Models\Favorite;
use App\Models\Follower;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * ユーザー詳細情報を取得
     *
     * @param Request $request
     * @return View
     */
    public function detail(Request $request):View
    {
        $user = new User();
        $user_detail = $user->detail($request->route('id'));
        $this->authorize('view', $user_detail);
        
        return view('user.show',compact('user_detail'));
    }

    /**
     * ユーザー情報編集画面への移動
     *
     * @return View
     */
    public function edit():View
    {
        $user = Auth::user();

        return view('user.edit',compact('user'));
    }

    /**
     * ユーザー情報を編集
     *
     * @param UserEditRequest $request
     * @return RedirectResponse
     */
    public function update(UserEditRequest $request):RedirectResponse
    {
        $user = new User();
        $name = $request->name;
        $email = $request->email;
        $user->updateData($name,$email);

        return redirect()->route('user.detail',['id' => Auth::id()]);
    }

    /**
     * ユーザー情報を削除
     *
     * @return View
     */
    public function delete():View
    {
        $user = new User();
        $user->deleteByUserID(Auth::id());

        return view('welcome');
    }

    /**
     * ユーザー一覧の表示
     *
     * @return View
     */
    public function index(Follower $follower):View
    {
        $user = new User();
        $users = $user->index();

        return view('user.index',compact('users','follower'));
    }

    /**
     * フォロー
     *
     * @param Follower $follower
     * @param User $user
     * @return RedirectResponse
     */
    public function follow(Follower $follower, User $user):RedirectResponse
    {
        try {
            $result = 'already';
            $flashMessage = '既にフォローしています';

            if (!$follower->isFollowing(Auth::id(), $user->id))
            {
                $follower->following_id = Auth::id();
                $follower->followed_id = $user->id;
                $this->authorize('follow',$follower);
                Auth::user()->follow($user->id);

                $result = 'success';
                $flashMessage = 'フォローしました！';
            } 

            return redirect()->route('user.index')->with($result, $flashMessage);
        } catch(\Exception $e) {
            Log::error($e);

            return redirect()->route('user.index')->with('error', 'フォローに失敗しました！');
        }
    }

    /**
     * フォロー解除
     *
     * @param User $user
     * @return void
     */
    public function unfollow(Follower $follower, User $user)
    {
        try {
            $result = 'already';
            $flashMessage = '既にフォロー解除しています';

            if ($follower->isFollowing(Auth::id(), $user->id))
            {
                Auth::user()->unfollow($user->id);
                
                $result = 'success';
                $flashMessage = 'フォロー解除しました！';
            } 

            return redirect()->route('user.index')->with($result, $flashMessage);
        } catch(\Exception $e) {
            Log::error($e);

            return redirect()->route('user.index')->with('error', 'フォロー解除に失敗しました！');
        }
    }

    /** 
     * フォロー表示
     *
     * @return View
     */
    public function getAllFollows():View
    {
        $users = Auth::user()->getAllFollows();

        return view('user.follow',compact('users'));
    }

    /**
     * フォロワー表示
     *
     * @return View
     */
    public function getAllFollowers():View
    {
        $users = Auth::user()->getAllFollowers();

        return view('user.follower',compact('users'));
    }

    /**
     * いいね機能
     *
     * @param Favorite $favorite
     * @param integer $tweetId
     * @return RedirectResponse
     */
    public function favorite(Favorite $favorite, int $tweetId):RedirectResponse
    {
        try {
            if (!$favorite->isFavorite(Auth::id(), $tweetId))
            {
                Auth::user()->favorite($tweetId);
            } 

            return back();
        } catch(\Exception $e) {
            Log::error($e);

            return back()->with('error', 'いいねできませんでした！');
        }
    }

    /**
     * いいね解除機能
     *
     * @param Favorite $favorite
     * @param integer $tweetId
     * @return RedirectResponse
     */
    public function unfavorite(Favorite $favorite, int $tweetId):RedirectResponse
    {
        try {
            if ($favorite->isFavorite(Auth::id(), $tweetId))
            {
                Auth::user()->unfavorite($tweetId);
            } 

            return back();
        } catch(\Exception $e) {
            Log::error($e);

            return back()->with('error', 'いいね解除できませんでした！');
        }
    }
}
