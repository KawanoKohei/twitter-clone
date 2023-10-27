<?php

namespace App\Http\Requests;

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
            'searchWord' => 'required|string|max:200'
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
            'tweet.required' => '検索ワードを入力してください',
            'tweet.between' => '200文字以内で入力してください',
        ];
    }
}
