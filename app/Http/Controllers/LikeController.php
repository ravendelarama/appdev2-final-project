<?php

namespace App\Http\Controllers;

use App\Models\Like;

class LikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $isLiked = Like::where('user_id', request()->user()->id)
            ->where('post_id', request()->input('post_id'))->first();

        if (!$isLiked) {
            $newLike = Like::create([
                "user_id" => request()->user()->id,
                "post_id" => request()->input("post_id")
            ]);
            return response()->json([
                "message" => "Post has been reposted.",
                "post" => $newLike->post
            ], 201);
        }

        return response()->json([
            "message" => "Already liked."
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Like $like)
    {
        if (request()->user()->id == $like->user_id) {
            $like->delete();

            return response()->json([
                "message" => "successful."
            ]);
        }

        return response()->json([
            "message" => "Unauthorized."
        ], 401);
    }
}
