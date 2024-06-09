<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RepostController;
use App\Http\Controllers\SavedPostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout');
});

Route::post('/refresh-token', [AuthController::class, 'refreshToken'])
    ->middleware('auth:sanctum', 'ability:issue-access-token');


Route::middleware('auth:sanctum', 'ability:basic-access')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('posts', PostController::class);
    Route::get('saved-posts', [PostController::class, 'savedPosts']);

    Route::apiResource('attachments', AttachmentController::class)->except(['index', 'update']);
    Route::apiResource('reposts', RepostController::class)->except(['index', 'update', 'show']);
    Route::apiResource('saved-posts', SavedPostController::class)->except(['index', 'update', 'show']);
    Route::apiResource('likes', LikeController::class)->except(['index', 'update', 'show']);
    Route::apiResource('follows', FollowController::class)->except(['index', 'update', 'show']);
});
