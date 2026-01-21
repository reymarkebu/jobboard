<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user(); // ✅ authenticated user

        return redirect()->route(
            match ((int) $user->role) {
                3 => 'dashboard',
                2 => 'employer.index',
                default => 'applicant.index',
            }
        );
    }
}
