<?php

namespace App\Http\Controllers;

use App\Models\SavedPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedPostController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $isExist = SavedPost::where("user_id", request()->user()->id)
            ->where("post_id", request()->input("post_id"))->first();

        if ($isExist) {
            return response()->json([
                "message" => "Post already saved.",
                "post" => $isExist
            ]);
        }

        $newSavedPost = SavedPost::create([
            "user_id" => request()->user()->id,
            "post_id" => request()->input("post_id")
        ]);

        return response()->json([
            "message" => "Post has been saved.",
            "post" => $newSavedPost
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SavedPost $savedPost)
    {
        if (request()->user()->id == $savedPost->user_id) {
            $savedPost->delete();

            return response()->json([
                "message" => "successful."
            ]);
        }

        return response()->json([
            "message" => "Unauthorized."
        ], 401);
    }
}
