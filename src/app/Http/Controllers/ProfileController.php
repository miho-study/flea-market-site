<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
     public function show()
{
    return view('users.profile');
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
