<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class ItemController extends Controller
{
public function index()
{
    $user = auth()->user();
    $niceIds = $user->nices()->pluck('product_id');

    // マイリスト（いいね済）
    $mylist = Product::whereIn('id', $niceIds)->get();

    // おすすめ（いいねしてない商品）
   $recommend = Product::whereNotIn('id', $niceIds)->get();

    return view('products.index', compact('mylist', 'recommend'));
}

public function search(Request $request)
{
    $keyword = $request->input('keyword');

    // 検索処理のサンプル（必要に応じて変更）
    $products = Product::where('product_name', 'like', "%{$keyword}%")->get();

    return view('products.index', compact('products'));
}


public function show($item_id)
{
    $product = Product::with([
        'category',
        'nices',
        'comments.user',
    ])
    ->withCount('comments') // ← ★これを追加
    ->findOrFail($item_id);

    return view('products.detail', compact('product'));
}

}
