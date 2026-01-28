<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'product_name' => ['required', 'string', 'max:255'],
            'brand_name' => ['nullable', 'string', 'max:255'],
            'product_description' => ['required', 'string', 'max:255'],
            'product_image' => ['required', 'image', 'mimes:jpeg,png'],
            'category_ids' => ['required', 'array'],
            'product_condition' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:1'],
        ];
    }

    public function messages()
    {
        return [
            'product_name.required' => '商品名を入力してください',
            'product_description.required' => '商品説明を入力してください',
            'product_description.max' => '商品説明は255文字以内で入力してください',
            'product_image.required' => '商品画像を選択してください',
            'product_image.image' => '商品画像は画像ファイルである必要があります',
            'product_image.mimes' => '商品画像はjpegまたはpng形式のファイルを選択してください',
            'category_ids.required' => 'カテゴリーを選択してください',
            'product_condition.required' => '商品の状態を選択してください',
            'price.required' => '価格を入力してください',
            'price.numeric' => '価格は数値で入力してください',
            'price.min' => '価格は1円以上で入力してください',
        ];
    }
}
