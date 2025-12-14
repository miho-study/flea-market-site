<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(LoginRequest $request)
    {
        // $credentials = $request->only('email', 'password');
        // if (auth()->attempt($credentials)) { $request->session()->regenerate(); // セッション固定攻撃対策 
        if (Auth::attempt($request->validated())) {
        $request->session()->regenerate();
        return redirect('/');
    }
    return back()->withErrors([
        'login' => 'ログイン情報が登録されていません。'
    ])->withInput();
    }
}
