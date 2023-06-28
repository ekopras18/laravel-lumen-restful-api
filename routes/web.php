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

$router->get('/key', function() {
    return \Illuminate\Support\Str::random(32);
});


$router->get('/', function () use ($router) {
    return response()
        ->json([
            'name' => 'Restful API Basic',
            'message' => 'This is basic restful api',
            'technology' => [
                'framework' => $router->app->version(),
                'Authantication' => 'Json Web Token (JWT)',
            ],
            'status' => 'Alive',
        ], 200);
});

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');
    $router->post('/reset-password', ['middleware' => 'auth', 'uses' => 'AuthController@reset_password']);
});

$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {
    //Settings
    $router->get('/profile', 'Settings\ProfileController@index');
    $router->put('/profile/{id}', 'Settings\ProfileController@update');

    //Portfolio
    $router->get('/portfolio', 'Portfolio\PortfolioController@index');
    $router->get('/portfolio/{id}', 'Portfolio\PortfolioController@show');
    $router->post('/portfolio', 'Portfolio\PortfolioController@store');
    $router->put('/portfolio/{id}', 'Portfolio\PortfolioController@update');
    $router->delete('/portfolio/{id}', 'Portfolio\PortfolioController@destroy');
});
