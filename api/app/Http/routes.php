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

Route::get('/', function() {
	return array('user' => 'derek', 'age' => '22', 'profession' => 'asdfasdf');
});

Route::group(['prefix' => 'api/v1'], function () {
	Route::get('/users', function() {
		return array('user' => 'derek', 'age' => '22', 'profession' => 'dev');
	});
});

Route::post('oauth/access_token', function() {
 return Response::json(Authorizer::issueAccessToken());
});

Route::get('/register', function() {
    $user = new App\User();
    $user->name="test user";
    $user->email="test@test.com";
    $user->password = \Illuminate\Support\Facades\Hash::make("password");
    $user->save();
});
