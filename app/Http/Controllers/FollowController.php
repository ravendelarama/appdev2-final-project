<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $isFollowed = Follow::where('user_id', request()->input('user_id'))
            ->where('follow_id', request()->user()->id)->first();

        if (!$isFollowed) {
            $newFollow = Follow::create([
                "user_id" => request()->input("user_id"),
                "follow_id" => request()->user()->id
            ]);

            return response()->json([
                "message" => "Followed.",
                "user" => $newFollow
            ], 201);
        }

        return response()->json([
            "message" => "Already followed."
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Follow $follow)
    {
        if (request()->user()->id == $follow->user_id) {
            $follow->delete();

            return response()->json([
                "message" => "Unfollowed."
            ]);
        }

        return response()->json([
            "message" => "Unauthorized."
        ], 401);
    }
}
