<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {return view('welcome');})->name('Welcome');

Auth::routes();

Route::get('/home', [HomeController::class, 'home'])->name('home');

//ユーザー認証
Route::group(['middleware' => 'auth'], function () {
    //ユーザー機能
    Route::group(['prefix' => 'user','as' => 'user.'], function()
    {
        //ユーザー詳細（プロフィール）表示
        Route::get('detail/{id}', [UserController::class, 'detail'])->name('detail');
        //編集ページ表示
        Route::get('edit', [UserController::class, 'edit'])->name('edit');
        //ユーザー情報編集
        Route::put('update', [UserController::class, 'update'])->name('update');
        //ユーザー削除
        Route::delete('delete',[UserController::class, 'delete'])->name('delete');
        //ユーザー一覧
        Route::get('index', [UserController::class, 'index'])->name('index');
        //フォロー
        Route::post('follow/{user}', [UserController::class, 'follow'])->name('follow');
        //フォロー解除
        Route::delete('unfollow/{user}', [UserController::class, 'unfollow'])->name('unfollow');
    });
    //ツイート機能
    Route::group(['prefix' => 'tweet', 'as' => 'tweet.'], function()
    {
        //ツイートページ表示
        Route::get('/', [TweetController::class, 'tweet'])->name('');
        //ツイート投稿作成
        Route::post('create', [TweetController::class, 'create'])->name('create');
        //ツイートの一覧表示
        Route::get('index', [TweetController::class, 'index'])->name('index');
        //ツイート詳細表示
        Route::get('detail/{tweet}', [TweetController::class, 'detail'])->name('detail');
        //ツイート編集ページ表示
        Route::get('edit/{tweet}', [TweetController::class, 'edit'])->name('edit');
        //ツイート編集
        Route::put('update/{tweet}', [TweetController::class, 'update'])->name('update');
        //ツイートの削除
        Route::delete('delete/{tweet}', [TweetController::class, 'delete'])->name('delete');
    });
});
