<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/docs', function () use ($router) {
    $openapi = \OpenApi\Generator::scan(['/var/www/html/app']);
    return response()->json($openapi);
});

$router->get('/airports/{id}', 'AirportController@show');
$router->post('/airports', 'AirportController@store');
$router->put('/airports/{id}', 'AirportController@update');
$router->delete('/airports/{id}', 'AirportController@destroy');
$router->get('/airports', 'AirportController@index');
