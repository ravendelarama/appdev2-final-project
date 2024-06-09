<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Quote;
use App\Models\Reply;
use App\Models\SavedPost;
use App\Models\View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            "posts" => Post::whereIn('type', ['quote', 'post'])->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $fields = $request->validated();


        $post = Post::create([
            "user_id" => request()->user()->id,
            "type" => $fields['type'],
            "caption" => $fields["caption"],
            "hide_like_and_share" => $fields["hide_like_and_share"]
        ]);

        if ($fields["type"] == "reply") {

            Reply::create([
                "children_id" => $post->id,
                "parent_id" => $fields["parent_id"]
            ]);

            return response()->json([
                "message" => "Post uploaded."
            ], 201);
        }

        if ($fields['type'] == "quote") {

            Quote::create([
                "quote_id" => $post->id,
                "reference_id" => $fields["quote_id"]
            ]);

            return response()->json([
                "message" => "Post uploaded.",
            ], 201);
        }

        return response()->json([
            "message" => "Post uploaded.",
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $post = Post::where('id', $id)
            ->with('views')
            ->with('reposts')
            ->with('likes')
            ->with('attachments')
            ->first();

        if (!$post) {
            return response()->json([
                "message" => "Not Found."
            ], 404);
        }

        $hasViewed = View::where('user_id', request()->user()->id)
            ->where('post_id', $id)->first();

        if (!$hasViewed) {
            View::create([
                "user_id" => request()->user()->id,
                "post_id" => $id
            ]);
        }

        return response()->json([
            'post' => $post,
            'replies' => Reply::where('parent_id', $post->id)->get(),
            'quotes' => Quote::where('reference_id', $post->id)->get(),
            'reference_post' => Quote::where('quote_id', $post->id)->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $fields = $request->validated();

        Post::where('id', $post->id)->update($fields);

        return response()->json([
            "message" => "Post updated.",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (request()->user()->id == $post->user_id) {
            $post->delete();

            return response()->json([
                "message" => "successful."
            ]);
        }

        return response()->json([
            "message" => "Unauthorized."
        ], 401);
    }

    public function savedPosts()
    {

        $posts = SavedPost::where('user_id', request()->user()->id)
            ->with('post')
            ->get();

        return response()->json([
            'posts' => $posts,
        ]);
    }
}
