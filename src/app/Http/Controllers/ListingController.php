<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    public function create()
    {
        $categories = Category::all();

    return view('products.listing', compact('categories'));
    }

    public function store(ExhibitionRequest $request)
    {
        $user = auth()->user();

        $data = $request->only([
            'product_name',
            'brand_name',
            'product_description',
            'product_condition',
            'price',
        ]);
        
        $data['user_id'] = $user->id;

        if ($request->hasFile('product_image')) {
            $productImagePath = $request->file('product_image')->store('products', 'public');
            $data['product_image'] = $productImagePath;
        }

        Product::create($data);

        return redirect()
            ->route('search')
            ->with('success', '商品を出品しました');
    }
}
