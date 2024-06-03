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
            $access_token = $request->user()->createToken(
                'access_token',
                ['basic-access'],
                Carbon::now()->addMinutes(config('sanctum.at_expiration'))
            );

            $refresh_token = $request->user()->createToken(
                'access_token',
                ['basic-access'],
                Carbon::now()->addMinutes(config('sanctum.rt_expiration'))
            );

            return response()->json([
                'access_token' => $access_token->plainTextToken,
                'refresh_token' => $refresh_token->plainTextToken
            ]);
        }

        return response()->json([
            'message' => 'Server error.'
        ]);
    }

    public function logout(Request $request)
    {
        if ($request->header('refresh-token')) {
            PersonalAccessToken::findToken($request->header('refresh-token'))->delete();
        }

        if ($request->bearerToken()) {
            PersonalAccessToken::findToken($request->bearerToken())->delete();
        }

        return response()->json([
            'message' => 'Signed out.'
        ]);
    }

    public function refreshToken(Request $request)
    {
        $token = $request->user()->createToken(
            'refresh_token',
            'issue-access-token',
            Carbon::now()->addMinutes(config('sanctum.rt_expiration'))
        );

        return response()->json([
            'access_token' => $token
        ]);
    }
}
