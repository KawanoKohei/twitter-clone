<?php

namespace App\Http\Requests;

use App\Const\TweetConst;
use Illuminate\Foundation\Http\FormRequest;

class SearchWordRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules():array
    {
        return [
            'searchWord' => 'required|string|between:' . TweetConst::TWEET_MINI_STRING . ',' . TweetConst::TWEET_MAX_STRING,
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
            'searchWord.required' => '検索ワードを入力してください',
            'searchWord.max' => TweetConst::TWEET_MAX_STRING . '文字以内で入力してください',
        ];
    }
}
