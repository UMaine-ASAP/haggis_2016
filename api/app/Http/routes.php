<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// prefix all api routes with "api/v1"
Route::group(['prefix' => 'api/v1'], function () {
	/**
	________       ______ __________       
	___  __ \___  ____  /____  /__(_)______
	__  /_/ /  / / /_  __ \_  /__  /_  ___/
	_  ____// /_/ /_  /_/ /  / _  / / /__  
	/_/     \__,_/ /_.___//_/  /_/  \___/ 

	**/

	Route::post('oauth/access_token', function() {
	    return Response::json(Authorizer::issueAccessToken());
	});

	Route::resource('users', 'UsersController');

	/**
	________             _____           _____     _________
	___  __ \______________  /_____________  /___________  /
	__  /_/ /_  ___/  __ \  __/  _ \  ___/  __/  _ \  __  / 
	_  ____/_  /   / /_/ / /_ /  __/ /__ / /_ /  __/ /_/ /  
	/_/     /_/    \____/\__/ \___/\___/ \__/ \___/\__,_/ 

	**/
    Route::group(['middleware' => 'oauth', 'before' => 'oauth'], function() {
        Route::get('/stuff', function() {
            $user_id=Authorizer::getResourceOwnerId(); // the token user_id
            $user=\App\User::find($user_id);// get the user data from database
            return Response::json($user);
        });


    });

});


