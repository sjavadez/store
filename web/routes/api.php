<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => 'Api\V1',
        'prefix' => 'v1'
    ],
    function () {
        Route::post('login', 'AuthController@login')->name('login');
        Route::delete('logout', 'AuthController@logout')->name('logout')->middleware('auth:sanctum');

        Route::middleware(['check-admin', 'auth:sanctum'])
            ->name('admin.')
            ->prefix('admin')
            ->namespace('Admin')
            ->group(function () {
                Route::apiResource('products', 'ProductController');
                Route::apiResource('seller', 'SellerController');
                Route::apiResource('comments', 'CommentController')->only(['index', 'update']);
                Route::apiResource('votes', 'VoteController')->only(['index', 'update']);
            });

        Route::middleware(['auth:sanctum'])
            ->namespace('Guest')
            ->group(function () {
                Route::put('products/{product}/vote', 'VoteController@store')->name('products.vote.put');
                Route::post('products/{product}/comment', 'CommentController@store')->name('products.comment.store.');

                Route::get('products', 'ProductController@index');
                Route::get('products/{product}', 'ProductController@show');
                Route::get('products/{product}/seller/{seller}/price', 'ProductController@sellerPrices');
            });

    }
);

