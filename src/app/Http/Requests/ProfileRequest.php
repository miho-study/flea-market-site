<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'profile_image' => ['nullable','mimes:jpeg,png'],
            'name' => ['required', 'max:20'],
            'post_code' => ['nullable', 'regex:/^\d{3}-\d{4}$/'],
            'address' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'profile_image.mimes' => 'プロフィール画像はjpegまたはpng形式のファイルを選択してください',
            'name.required' => 'お名前を入力してください',
            'name.max' => 'お名前は20文字以内で入力してください',
            'post_code.regex' => '郵便番号はXXX-XXXXの形式で入力してください',
            'address.required' => '住所を入力してください',
        ];
    }
}
