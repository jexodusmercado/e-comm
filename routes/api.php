<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



Route::prefix('products')->group(function () {
    Route::get('/{id}', 'Api\ProductController@index');
    Route::get('/remove/{id}', 'Api\ProductController@edit');
    Route::get('/view/{id}', 'Api\ProductController@show');
    Route::post('/save', 'Api\ProductSave');
});

Route::prefix('user')->group(function (){
    Route::get('/view/{id}', 'Api\UserController@show');
    Route::get('/verify/{id}', 'Api\UserController@updateRole');
    Route::get('/notVerified', 'Api\UserController@showUnverified');
    Route::post('/update/{id}', 'Api\UserController@update');
});

Route::prefix('auction')->group(function(){
    Route::get('/check/{id}', 'Api\AuctionLinesController@show');
    Route::post('/offer', 'Api\AuctionStoreBetController');
    Route::post('/accept', 'Api\AuctionAcceptedBetController');
});

Route::prefix('market')->group(function () {
    Route::get('/', 'Api\MarketController@index');
});

Route::prefix('inquiries')->group(function (){
    Route::post('/save', 'Api\InquiryStoreController');
    Route::get('/',   'Api\InquiryController@index');
});

Route::prefix('delivery')->group(function (){
    Route::get('/user/{id}',  'Api\DeliverableController@index');
    Route::get('/job/{id}',  'Api\DeliverableController@sellerIndex');
    Route::get('/check/{id}', 'Api\DeliverableController@show');
    Route::post('/status/update/', 'Api\DeliverableController@update');
});

Route::prefix('rate')->group(function (){
    Route::get('/product/{id}',  'Api\RatingController@showByProduct');
    Route::get('/user/{id}',  'Api\RatingController@showByProfile');
    Route::get('/count/{id}',  'Api\RatingController@totalStars');
    Route::get('/check/{id}/{buyerId}',  'Api\RatingController@showByBuyer');
    Route::post('/save',  'Api\RatingStoreController');

});

