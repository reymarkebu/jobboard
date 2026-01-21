<?php

namespace App\Http\Responses;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Laravel\Fortify\Contracts\LoginViewResponse as LoginViewResponseContract;

class LoginViewResponse implements LoginViewResponseContract
{
    public function toResponse($request)
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => true,
            'canRegister' => true,
            'status' => session('status'),
            'role' => $request->query('role'),
        ]);
    }
}
