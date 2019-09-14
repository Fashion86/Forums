<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Exception;

class LogoutController extends Controller
{  
    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            Auth::guard()->logout();
        } catch(Exception $e) {

        }
        return response()
            ->json(['message' => 'Successfully logged out']);
    }
}
