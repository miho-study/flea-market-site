<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        return app(AuthenticatedSessionController::class)->store($request);
    }
}
