<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\ProfileRequest;
// use App\Models\Purchase;
use App\Models\Product; 
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
     public function show()
{
    $user = Auth::user();

    $sellingProducts = Product::where('user_id', $user->id)->get();

    // $purchasedProducts = Purchase::with('product')
    //     ->where('user_id', $user->id)
    //     ->get();

    return view('users.profile', compact(
        'sellingProducts',
        // 'purchasedProducts'
    ));
}

    public function edit()
    {
        $user = auth()->user();
    return view('users.edit', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = auth()->user();

        $data = $request->only(['name', 'address', 'post_code', 'building_name', 'profile_picture']);

        if ($request->hasFile('profile_picture')) {
            $profileImagePath = $request->file('profile_picture')->store('profiles', 'public');
            $data['profile_picture'] = $profileImagePath;
        }

        $user->update($data);

        return redirect('/mypage/profile')->with('success', 'プロフィールを更新しました');
    }
}
