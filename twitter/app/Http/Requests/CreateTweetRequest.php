<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTweetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize():bool
    {
        return $this->path() == 'tweet/create';
    }

    /**
     * ツイートにおけるバリデーション
     *
     * @return array
     */
    public function rules():array
    {
        return [
            'tweet' => 'required|between:1,' . \App\Const\TweetConst::TWEET_MAX_STRING
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
            'tweet.between' => '140文字以内で入力してください',
        ];
    }
}
