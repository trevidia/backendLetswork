<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GigsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Authentication of routes
Route::middleware('auth:sanctum')->group(function (){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::put('/user/{user}', [UserController::class, "update"]);
});
Route::post('/login', [UserController::class, "store"]);


Route::post('/logout', [UserController::class, "logout"]);

// creation of gigs

Route::post('/create_gig', [GigsController::class, 'create']);

Route::get('/categories', [CategoryController::class, 'show']);
