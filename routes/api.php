<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\AuthController;
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


Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);


Route::middleware('auth:sanctum', 'ability:basic-access')->group(function () {
    Route::apiResources([
        'users' => UserController::class,
        'posts' => PostController::class
    ]);

    Route::apiResource('attachments', AttachmentController::class)->except(['index', 'update']);
    Route::apiResource('reposts', RepostController::class)->except(['index', 'update']);
    Route::apiResource('saved-posts', SavedPostController::class)->except(['index', 'update']);
    Route::apiResource('likes', LikeController::class)->except(['index', 'update']);
});
