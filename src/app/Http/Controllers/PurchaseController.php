<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\ProfileRequest;

class PurchaseController extends Controller
{
public function confirm($item_id)
{
    $product = Product::findOrFail($item_id);
    $user = Auth::user();

    $hasCommented = $product->comments()
        ->where('user_id', $user->id)
        ->exists();

    if (! $hasCommented) {
        return back()->withErrors([
            'comment' => '購入するには、この商品にコメントを投稿してください'
        ]);
    }

    $address = session('purchase_address') ?? [
        'post_code' => $user->post_code,
        'address' => $user->address,
        'building_name' => $user->building_name,
    ];

    return view('purchases.purchase', compact('product', 'address'));
}

public function store(PurchaseRequest $request, $item_id)
{
    $product = Product::findOrFail($item_id);
    $user = Auth::user();

    $address = session('purchase_address') ?? [
        'post_code' => $user->post_code,
        'address' => $user->address,
        'building_name' => $user->building_name,
    ];

    $shipping = trim($address['address'] ?? '');

        Purchase::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'payment_method' => $request->payment_method,
            'shipping_postcode' => $address['post_code'] ?? '',
            'shipping_address' => $shipping,
            'shipping_building' => $address['building_name'] ?? '',
        ]);

    session()->forget('purchase_address');

    $product->update(['is_sold' => true]);

    return redirect()->route('index')->with('success', '購入が完了しました');
}


public function edit($item_id)
{
    $user = Auth::user();

    $address = session('purchase_address') ?? [
        'post_code' => $user->post_code,
        'address' => $user->address,
        'building_name' => $user->building_name,
    ];

    return view('purchases.address', compact('item_id', 'address'));
}

public function update(AddressRequest $request, $item_id)
{
    session([
        'purchase_address' => [
            'post_code' => $request->post_code,
            'address' => $request->address,
            'building_name' => $request->building_name,
        ]
    ]);

    return redirect()->route('purchase.confirm', $item_id);
}
}