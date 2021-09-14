<?php
 Route::group(['middleware' => ['api'], 'prefix' => 'v1'], function () {

    // Authentication
    Route::post('auth', 'AuthController@login');

    // New Account Creation
    Route::post('signup', 'AuthController@signup');

    // Expire Token
    Route::post('logout', 'AuthController@logout');

    // Refresh the Token
    Route::post('reAuthenticate', 'AuthController@refresh');

    // Logged user information
    Route::get('user', 'AuthController@userInfo');

    // Users
    Route::resource('users','UsersController');

    // Products
    Route::resource('/products','ProductsController');

    // User's Products
    Route::resource('user/products','PurchaseItemController');


});
