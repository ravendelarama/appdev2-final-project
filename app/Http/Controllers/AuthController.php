<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function login(LoginUserRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $token = $request->user()->createToken(
                'access_token',
                ['basic-access'],
                Carbon::now()->addMinutes(config('sanctum.expiration'))
            );

            return response()->json([
                'access_token' => $token->plainTextToken
            ]);
        }

        return response()->json([
            'message' => 'Server error.'
        ]);
    }

    public function logout(Request $request)
    {
        if ($request->bearerToken()) {
            PersonalAccessToken::findToken($request->bearerToken())->delete();
        }

        return response()->json([
            'message' => 'Signed out.'
        ]);
    }
}
