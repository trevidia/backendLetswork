<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GigsController;
use App\Http\Controllers\PackageSpecController;
use App\Http\Controllers\SubCategoryController;
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

Route::get('/users', [UserController::class, 'index']);
Route::get('/user/{username}', [UserController::class, 'showUser']);

Route::post('/login', [UserController::class, "store"]);

Route::resource('package_spec', PackageSpecController::class);

Route::post('/logout', [UserController::class, "logout"]);

Route::get('/user_gigs/{user}', [GigsController::class, "proposalStatus"]);
Route::get('/gig/{gigId}', [GigsController::class, "view"]);
Route::patch('/gig/{gigId}', [GigsController::class, "updateGig"]);
Route::post('/gig_image/{gigId}', [GigsController::class, "saveImages"]);
Route::patch('/deactivate_gig/{gigId}', [GigsController::class, "deactivate"]);
Route::patch('/activate_gig/{gigId}', [GigsController::class, "activate"]);
Route::delete('/delete_gig/{gigId}', [GigsController::class, "delete"]);

// creation of gigs

Route::post('/create_gig', [GigsController::class, 'create']);

Route::get('/categories', [CategoryController::class, 'show']);
Route::post('/categories', [CategoryController::class, 'create']);
Route::get('/category', [CategoryController::class, 'categories']);
Route::put('/category/{catId}', [CategoryController::class, 'update']);
Route::get('/category/{catId}', [CategoryController::class, 'getCategory']);
Route::delete('/category/{catId}', [CategoryController::class, "destroy"]);

Route::post('/subcategory', [SubCategoryController::class, 'create']);
Route::get('/subcategory', [SubCategoryController::class, 'viewPaginated']);
Route::get('/subcategory/{subId}', [SubCategoryController::class, 'getSubCat']);
Route::post('/subcategory/{subId}', [SubCategoryController::class, 'updateSubcat']);
Route::post("/package_spec", [PackageSpecController::class, 'store']);
Route::get("/package_spec", [PackageSpecController::class, 'index']);
Route::get("/package_spec/{id}", [PackageSpecController::class, 'show']);
Route::put("/package_spec/{id}", [PackageSpecController::class, 'update']);
