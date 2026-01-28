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
    $userId = Auth::id();

    $tab = $request->query('tab', 'recommend');
    if (!in_array($tab, ['recommend', 'mylist'])) {
        $tab = 'recommend';
    }

    $likedProductIds = $user
        ? $user->nices()->pluck('product_id')
        : collect();

    $myListProducts = $user
        ? Product::whereIn('id', $likedProductIds)
            ->where('user_id', '!=', $userId)
            ->get()
        : collect();

    $recommendProducts = Product::whereNotIn('id', $likedProductIds)
        ->when($userId, function ($query) use ($userId) {
            $query->where('user_id', '!=', $userId);
        })
        ->get();

    return view('products.index', compact(
        'tab',
        'myListProducts',
        'recommendProducts'
    ));
}

public function search(Request $request)
{
    $user = Auth::user();

    $keyword = $request->input('keyword');
    $products = Product::where('product_name', 'like', "%{$keyword}%")->get();

    $likedProductIds = $user
        ? $user->nices()->pluck('product_id')
        : collect();

    $myListProducts = $user
        ? Product::whereIn('id', $likedProductIds)->get()
        : collect();

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
        'categories',
        'nices',
        'comments.user',
    ])
    ->withCount('comments')
    ->findOrFail($item_id);

    $isLiked = false;

    if (Auth::check()) {
        $isLiked = $product->nices()
            ->where('user_id', Auth::id())
            ->exists();
    }

    return view('products.detail', compact('product', 'isLiked'));
}


}
