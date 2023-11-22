<?php

namespace App\Http\Requests;

use App\Const\TweetConst;
use Illuminate\Foundation\Http\FormRequest;

class UserEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize():bool
    {
        return $this->path() == 'user/update';
    }

    /**
     * ユーザー編集におけるバリデーション
     *
     * @return array
     */
    public function rules():array
    {
        return [
            'name' => 'required|between:' . TweetConst::TWEET_MINI_STRING . ',' . TweetConst::TWEET_MAX_STRING,
            'email' => 'required|email:filter,dns',
        ];
    }

    /**
     * ビューで表示されるメッセージ
     *
     * @return array
     */
    public function messages():array
    {
        return [
            'name.required' => '名前は必須項目です。必ず入力してください',
            'name.between' => TweetConst::TWEET_MAX_STRING . '文字以内で入力してください',
            'email.required' => 'メールアドレスは必須項目です。必ず入力してください',
            'email.email' => 'メールアドレスの書式に誤りがあります。メールアドレスを正しく入力しなおしてください。',
        ];
    }


}
