<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
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
        Route::post('/', [CategoryController::class, 'store'])->name('api.category.store');
        // Delete exists category
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->where('id', '')->name('api.category.delete');
    });
    
    // product routes
    Route::prefix('products')->group(function(){
        Route::get('/', [ProductController::class, 'index'])->name('api.product.fetch');
        // Store new product
        Route::post('/', [ProductController::class, 'store'])->name('api.product.store');
        // Delete exists product
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('api.product.delete');
    });
});
