<?php

namespace App\Http\Controllers;

use App\Models\Repost;
use Illuminate\Http\Request;

class RepostController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $newRepost = Repost::create([
            "user_id" => request()->user()->id,
            "post_id" => request()->input("post_id")
        ]);

        return response()->json([
            "message" => "Post has been reposted.",
            "post" => $newRepost
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Repost $repost)
    {
        if (request()->user()->id == $repost->user_id) {
            $repost->delete();

            return response()->json([
                "message" => "successful."
            ]);
        }

        return response()->json([
            "message" => "Unauthorized."
        ], 401);
    }
}
