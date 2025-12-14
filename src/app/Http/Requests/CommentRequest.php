<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // return [
        //     'comment_id' => ['required', 'max:255'],
        // ];
    }
    // public function messages()
    // {
    //     return [
    //         'comment_id.required' => 'コメントを入力してください',
    //         'comment_id.max' => 'コメントは255文字以内で入力してください',
    //     ];
    // }
}
