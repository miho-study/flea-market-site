<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
public function index(Request $request)
{
    $user = Auth::user();

    // tab がなければ recommend、想定外は弾く
    $tab = $request->query('tab', 'recommend');
    if (!in_array($tab, ['recommend', 'mylist'])) {
        $tab = 'recommend';
    }

    // いいねしている商品ID
    $likedProductIds = $user
        ? $user->nices()->pluck('product_id')
        : collect();

    // マイリスト商品
    $myListProducts = $user
        ? Product::whereIn('id', $likedProductIds)->get()
        : collect();

    // おすすめ商品（マイリスト以外）
    $recommendProducts = Product::whereNotIn('id', $likedProductIds)->get();

    return view('products.index', [
        'tab' => $tab,
        'myListProducts' => $myListProducts,
        'recommendProducts' => $recommendProducts,
    ]);
}

public function search(Request $request)
{
    $user = Auth::user();

    // 検索キーワード
    $keyword = $request->input('keyword');
    $products = Product::where('product_name', 'like', "%{$keyword}%")->get();

    // いいねしている商品ID
    $likedProductIds = $user
        ? $user->nices()->pluck('product_id')
        : collect();

    // マイリスト商品
    $myListProducts = $user
        ? Product::whereIn('id', $likedProductIds)->get()
        : collect();

    // 検索結果を'おすすめ'タブとして表示
    $recommendProducts = $products;
    $tab = 'recommend';

    return view('products.index', [
        'tab' => $tab,
        'myListProducts' => $myListProducts,
        'recommendProducts' => $recommendProducts,
    ]);
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
