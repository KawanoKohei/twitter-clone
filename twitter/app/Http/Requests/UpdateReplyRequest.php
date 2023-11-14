<?php

namespace App\Http\Requests;

use App\Const\TweetConst;
use Illuminate\Foundation\Http\FormRequest;

class UpdateReplyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * リプライ更新におけるバリデーション
     *
     * @return array
     */
    public function rules():array
    {
        return [
            'reply' =>  'required|string|between:1,' . TweetConst::TWEET_MAX_STRING,
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
            'reply.required' => 'リプライを入力してください',
            'reply.between' => '140文字以内で入力してください',
        ];
    }
}
