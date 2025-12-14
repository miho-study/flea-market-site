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
        //     'product_id' =>['required'],
        //     'product_description' =>['required', 'max:255'],
        //     'product_image' =>['required','mimes:jpeg,png'],
        //     'category_name' =>['required'],
        //     'product_condition' =>['required'],
        //     'price' =>['required','numeric','min:0'],
        // ];
    }

    // public function messages()
    // {
    //     return [
    //         'product_id.required' => '商品名を入力してください',
    //         'product_description.required' => '商品説明を入力してください',
    //         'product_description.max' => '商品説明は255文字以内で入力してください',
    //         'product_image.required' => '商品画像を選択してください',
    //         'product_image.mimes' => '商品画像はjpegまたはpng形式のファイルを選択してください',
    //         'category_name.required' => 'カテゴリーを選択してください',
    //         'product_condition.required' => '商品の状態を選択してください',
    //         'price.required' => '価格を入力してください',
    //         'price.numeric' => '価格は数値で入力してください',
    //         'price.min' => '価格は0以上で入力してください',
    //     ];
    // }
}
