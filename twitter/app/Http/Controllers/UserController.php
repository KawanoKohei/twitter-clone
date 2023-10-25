<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserEditRequest;
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
    public function index():View
    {
        $user = new User();
        $users = $user->index();
        
        return view('user.index',compact('users'));
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
            $follower->follower_id = Auth::id();
            $bool = $user->isFollowing($user->id, Auth::id());
            if (!$bool)
            {
                $follower->following_id = $user->id;
                $this->authorize('follow',$follower);
                $follower->follow();
            } else{
                return redirect()->route('user.index')->with('already', '既にフォローしています');
            }

            return redirect()->route('user.index')->with('success', 'フォローしました！');
        } catch(\Exception $e) {
            Log::error($e);

            return redirect()->route('user.index')->with('error', 'フォローに失敗しました！');
        }
    }

    /**
     * フォロー解除
     *
     * @param Follower $follower
     * @param User $user
     * @return void
     */
    public function unfollow(Follower $follower, User $user):RedirectResponse
    {
        try {
            $bool = $user->isFollowing($user->id, Auth::id());
            if ($bool)
            {
                $follower->unfollow($user->id, Auth::id());
            } else{
                return redirect()->route('user.index')->with('already', '既にフォロー解除しています');
            }

            return redirect()->route('user.index')->with('success', 'フォロー解除しました！');
        } catch(\Exception $e) {
            Log::error($e);

            return redirect()->route('user.index')->with('error', 'フォロー解除に失敗しました！');
        }
    }

    /**
     * フォロー一覧表示
     *
     * @param User $user
     * @return View
     */
    public function follower(User $user):View
    {
        $followers = $user->getAllFollowers(Auth::id());
        dd($followers);

        return view('user.follower',compact('followers'));
    }
}
