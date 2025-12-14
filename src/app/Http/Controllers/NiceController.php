<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;   // ← これが必要
use Illuminate\Support\Facades\Auth;

class NiceController extends Controller
{
    public function store(Product $product)
    {
        // ログインしていない場合は弾く
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'ログインが必要です');
        }

        // 重複 Nice 防止
        if (!$user->nices()->where('product_id', $product->id)->exists()) {
            $user->nices()->create([
                'product_id' => $product->id
            ]);
        }

        return back();
    }
}
