<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\User;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
	return $router->app->version();
});

$router->post('/login', 		'AuthController@login');
$router->post('/register', 	'AuthController@register');
$router->delete('/unregister', 	'AuthController@unregister');
$router->get('/logout', 		'AuthController@logout');

$router->group(
	['prefix' => 'provider'],
	function ($router) {
		$router->get('/', 'ProviderController@index');
		$router->post('/', 'ProviderController@store');
		$router->delete('/', 'ProviderController@destroy');
	}
);

$router->group(
	['prefix' => 'rate'],
	function ($router) {
		$router->get('/', 'RateController@index');
		$router->post('/', 'RateController@store');
		$router->delete('/', 'RateController@destroy');
	}
);

$router->get('/user', function () {
	try {
		$data = User::all();

		return response()->json([
			'data' => $data,
			'message' => 'user successfully retrieved',
		]);
	} catch (\Exception $e) {
		return response()->json([
			'message' => 'retrieve user failed',
			'error' => $e
		]);
	}
});
