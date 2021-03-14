<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// API routes version one
Route::prefix('v1')->group(function(){
    // API status
    Route::get('/', function(){
        return 'API is ' . (config('app.debug') ? 'online' : 'offline');
    });

    // Category routes
    Route::prefix('categories')->group(function(){
        // Store new category
        Route::post('/', [CategoryController::class, 'store']);
        Route::get('/{category}', [CategoryController::class, 'destroy']);
    });
});
