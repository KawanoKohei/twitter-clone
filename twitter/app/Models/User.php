<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * ユーザー詳細情報を取得
     *
     * @param int $id
     * @return User|null
     */
    public function detail(int $id):User|null
    {
        return User::find($id);
    }

    /** 
     * ユーザー情報の編集
     *
     * @param string $name
     * @param string $email
     * @return void
     */    
    public function updateData(string $name, string $email):void
    {
        $user = Auth::user();
        $user->name = $name;
        $user->email = $email;
        $user->save();
    }

    /**
     * ユーザー情報を削除
     *
     * @param int $id
     * @return void
     */
    public function deleteByUserID(int $id):void
    {
        $this->destroy($id);
    }
    
    /**
     * ユーザー一覧の表示
     *
     * @return Collection
     */
    public function getAll():Collection
    {
        return User::whereNull('deleted_at')->orderBy('id', 'asc')->get();
    }

}  

