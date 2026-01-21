<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use App\Models\User; // Import your User model if needed

class RegisterResponse implements RegisterResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $user = $request->user();

        return redirect()->route(
            $user->role == 1
                ? 'applicant.index'
                : 'employer.index'
        );
    }
}
