<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Address;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\ProfileRequest;

class PurchaseController extends Controller
{
public function confirm($item_id)
{
    $product = Product::findOrFail($item_id);

    $address = session('purchase_address') ?? [
        'post_code' => Auth::user()->post_code,
        'address'   => Auth::user()->address,
        'building_name'  => Auth::user()->building_name,
    ];

    return view('purchases.purchase', compact('product', 'address'));
}

public function store(PurchaseRequest $request, $item_id)
{
    $product = Product::findOrFail($item_id);

    $address = session('purchase_address') ?? [
        'post_code' => Auth::user()->post_code,
        'address'   => Auth::user()->address,
        'building_name'  => Auth::user()->building_name,
    ];

    Purchase::create([
        'user_id' => Auth::id(),
        'product_id' => $product->id,
        'payment_method' => $request->payment_method,
        'shipping_postcode' => $address['post_code'],
        'shipping_address' => $address['address'],
        'shipping_building' => $address['building_name'],
    ]);

    session()->forget('purchase_address');

    $product->update([
        'is_sold' => true,
    ]);

    return redirect()->route('index')->with('success', '購入が完了しました');
}

    // 住所変更画面表示
    public function edit($item_id)
    {
        $user = Auth::user();

        $address = Address::where('user_id', $user->id)
            ->where('is_default', true)
            ->first();

        return view('purchases.address', compact(
            'item_id',
            'address'
        ));
    }

    // 住所更新処理
    public function update(AddressRequest $request, $item_id)
    {
        $request->validate([
            'post_code' => 'required',
            'address'   => 'required',
        ]);

    // session に保存（購入中の一時住所）
        session([
            'purchase_address' => [
                'post_code' => $request->post_code,
                'address'   => $request->address,
                'building_name'  => $request->building_name,
            ]
        ]);

        // 確認画面に戻す（存在するルート名に合わせる）
        return redirect()->route('purchase.confirm', $item_id);
    }
}