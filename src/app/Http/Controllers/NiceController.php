<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nice;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class NiceController extends Controller
{
    public function store($item_id)
    {
        $user = Auth::user();

        // 商品取得
        $product = Product::findOrFail($item_id);

        // すでにいいねしているか確認
        $nice = Nice::where('user_id', $user->id)
                    ->where('product_id', $product->id)
                    ->first();

        if ($nice) {
            // いいね解除
            $nice->delete();
        } else {
            // いいね追加
            Nice::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
        }

        return back();
    }
}
