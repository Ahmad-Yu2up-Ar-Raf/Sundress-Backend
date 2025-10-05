<?php

use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\WhishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


require __DIR__.'/auth.php';


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', function () {
    return ['message' => 'API works'];
});




//  Route::apiResource('whistlist', WhishlistController::class)->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('whistlist', WhishlistController::class);
    Route::apiResource('orders', OrdersController::class);

        Route::post('unwhistlist', [WhishlistController::class , 'unwhislited'])
       
    ->name('unwhistlist');
});
Route::apiResource('products', ProductsController::class);
