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
        
        $data = $request->validated();

        $user = $creator->create($data);
        
        Auth::login($user);

        return redirect('/mypage/profile');
    }


}
