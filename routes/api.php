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
    // Category routes
    Route::prefix('categories')->group(function(){
        Route::get('/', [CategoryController::class, 'index'])->name('api.category.fetch');
        Route::post('/', [CategoryController::class, 'store'])->name('api.category.store');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->where('id', '[0-9]+')->name('api.category.delete');
    });
    
    // product routes
    Route::prefix('products')->group(function(){
        Route::get('/', [ProductController::class, 'index'])->name('api.product.fetch');
        Route::get('/{category}', [ProductController::class, 'byCategory'])->where('category', '[0-9]+')->name('api.product.fetchByCategory');
        Route::post('/', [ProductController::class, 'store'])->name('api.product.store');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->where('id', '[0-9]+')->name('api.product.delete');
    });
});
