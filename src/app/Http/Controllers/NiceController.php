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
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $userId = Auth::id();

    $product = Product::findOrFail($item_id);

    if ($userId === $product->user_id) {
        return back()->with('error', '出品者はいいねできません');
    }

    $nice = Nice::where('user_id', $userId)
        ->where('product_id', $product->id)
        ->first();

    if ($nice) {
        $nice->delete();
    } else {
        Nice::create([
            'user_id' => $userId,
            'product_id' => $product->id,
        ]);
    }

    return back();
}

}