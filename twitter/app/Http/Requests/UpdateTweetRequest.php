<?php

namespace App\Http\Requests;

use App\Const\TweetConst;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTweetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize():bool
    {
        return true;
    }

    /**
     * ツイート更新におけるバリデーション
     *
     * @return array
     */
    public function rules():array
    {
        return [
            'tweet' => 'required|string|between:' . TweetConst::TWEET_MINI_STRING . ',' . TweetConst::TWEET_MAX_STRING,
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
            'tweet.required' => 'ツイートを入力してください',
            'tweet.between' => TweetConst::TWEET_MAX_STRING . '文字以内で入力してください',
        ];
    }
}
