<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
        public function showRegisterForm()
    {
        return view('auth.register');
    }
    public function register(RegisterRequest $request, CreatesNewUsers $creator)
    {
        
        // RegisterRequest のバリデーション
        $data = $request->validated();

        // Fortify のユーザー作成処理を使用
        $user = $creator->create($data);

        // 登録後にログイン（任意）
        Auth::login($user);

        return redirect('/mypage/profile');
    }


}
