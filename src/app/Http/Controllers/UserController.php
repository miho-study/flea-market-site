<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');  // 適宜変更
    }
    public function showLoginForm()
{
    return view('auth.login');
}

}