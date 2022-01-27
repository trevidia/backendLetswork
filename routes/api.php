<?php

use App\Http\Controllers\AccountSetupController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GigsController;
use App\Http\Controllers\PackageSpecController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\SubCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLanguageController;

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

// routes relating to users
Route::get('/users', [UserController::class, 'index']);
Route::get('/user/{username}', [UserController::class, 'showUser']);
Route::post('/login', [UserController::class, "store"]);
Route::resource('package_spec', PackageSpecController::class);
Route::post('/logout', [UserController::class, "logout"]);


// creation of gigs

Route::get('/user_gigs/{user}', [GigsController::class, "proposalStatus"]);
Route::get('/gig/{gigId}', [GigsController::class, "view"]);
Route::patch('/gig/{gigId}', [GigsController::class, "updateGig"]);

// gets a particular gig based on the gigs slug
Route::get('/seller_gig/{gig_slug}', [GigsController::class, "sellGig"]);

// gets all the gigs in the database
Route::get('/seller_gig', [GigsController::class, "index"]);
Route::post('/gig_image/{gigId}', [GigsController::class, "saveImages"]);
Route::patch('/deactivate_gig/{gigId}', [GigsController::class, "deactivate"]);
Route::patch('/activate_gig/{gigId}', [GigsController::class, "activate"]);
Route::delete('/delete_gig/{gigId}', [GigsController::class, "delete"]);
Route::post('/create_gig', [GigsController::class, 'create']);


// Category routes

Route::get('/categories', [CategoryController::class, 'show']);
Route::post('/categories', [CategoryController::class, 'create']);
Route::get('/category', [CategoryController::class, 'categories']);
Route::put('/category/{catId}', [CategoryController::class, 'update']);
Route::get('/category/{catId}', [CategoryController::class, 'getCategory']);
Route::delete('/category/{catId}', [CategoryController::class, "destroy"]);

// Subcategory along with packageSpec routes

Route::post('/subcategory', [SubCategoryController::class, 'create']);
Route::get('/subcategory', [SubCategoryController::class, 'viewPaginated']);
Route::get('/subcategory/{subId}', [SubCategoryController::class, 'getSubCat']);
Route::post('/subcategory/{subId}', [SubCategoryController::class, 'updateSubcat']);
Route::post("/package_spec", [PackageSpecController::class, 'store']);
Route::get("/package_spec", [PackageSpecController::class, 'index']);
Route::get("/package_spec/{id}", [PackageSpecController::class, 'show']);
Route::put("/package_spec/{id}", [PackageSpecController::class, 'update']);

// Skill Routes

Route::post('/skill', [SkillController::class, 'store']);
Route::get('/skill', [SkillController::class, "index"]);
Route::get('/skill/{skillId}', [SkillController::class, "show"]);
Route::put('/skill/{skillId}', [SkillController::class, "update"]);
Route::delete('/skill/{skillId}', [SkillController::class, "destroy"]);

// Seller Language Routes
Route::post('/seller_language', [UserLanguageController::class, 'store']);
Route::get('/seller_language', [UserLanguageController::class, 'index']);
Route::get('/seller_language/{sellerLanguage}', [UserLanguageController::class, 'show']);
Route::put('/seller_language/{sellerLanguage}', [UserLanguageController::class, 'update']);
Route::delete('/seller_language/{sellerLanguage}', [UserLanguageController::class, 'destroy']);

// Account Setup
Route::post("/account_setup/create_account", [AccountSetupController::class, "createAccount"]);
Route::post("/account_setup/category", [AccountSetupController::class, "category"]);
Route::post("/account_setup/expertise", [AccountSetupController::class, "skill"]);
Route::post("/account_setup/seller_language", [AccountSetupController::class, "languages"]);
Route::post("/account_setup/overview", [AccountSetupController::class, "overview"]);
Route::post("/account_setup/profile_image", [AccountSetupController::class, "profileImage"]);

