<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Favorite;
use App\Http\Controllers\SearchRecord;
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

Route::prefix('v1')->group(function(){

    Route::post('register', [ApiAuthController::class, "register"]);

    Route::post('login', [ApiAuthController::class, "login"]);
    Route::post('logout', [ApiAuthController::class, "logout"])->middleware('auth:sanctum');

    Route::post('logoutAll', [ApiAuthController::class, "logoutAll"])->middleware('auth:sanctum');

    Route::post('devices', [ApiAuthController::class, "devices"])->middleware('auth:sanctum');

    Route::apiResource("contact",ContactController::class)->middleware('auth:sanctum');

   Route::post('search',[SearchRecord::class,"store"]);

   Route::delete('search',[SearchRecord::class,"destroy"]);

   Route::post('fav',[Favorite::class,"store"]);

   Route::delete('fav',[Favorite::class,"destroy"]);


});


