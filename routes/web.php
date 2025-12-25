<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get( '/', \App\Http\Controllers\HomeController::class )->name( 'home' );

Route::group( [ 'middleware' => 'auth' ], function () {
    Route::post( '/cart/add', [ \App\Http\Controllers\CartController::class, 'add' ] )->name( 'cart.add' );
    Route::post( '/cart/remove', [ \App\Http\Controllers\CartController::class, 'remove' ] )->name( 'cart.remove' );
    Route::post( '/cart/update/{type}', [ \App\Http\Controllers\CartController::class, 'update' ] )->name( 'cart.update' );
    Route::post( '/order/store', [ \App\Http\Controllers\OrderController::class, 'store' ] )->name( 'order.store' );
} );

Route::middleware( [ 'auth', 'verified' ] )->group( function () {
    Route::get( 'dashboard', function () {
        return Inertia::render( 'dashboard' );
    } )->name( 'dashboard' );
} );

require __DIR__ . '/settings.php';
