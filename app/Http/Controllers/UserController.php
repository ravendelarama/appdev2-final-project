<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return response()->json([
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $credentials = $request->validated();
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $user = User::where('id', $id)->with('followers')->with('followings')->get();

        return response()->json([
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $fields = $request->validated();

        if (request()->user()->id == $user->id) {
            User::where('id', $user->id)->update($fields);

            return response()->json([
                "message" => "Updated.",
            ]);
        }

        return response()->json([
            "message" => "Unauthorized."
        ], 401);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => 'Deleted successfully.'
        ]);
    }
}
