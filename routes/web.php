<?php

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

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('register', 'AuthController@register');

    $router->post('login', 'AuthController@login');

    $router->post('deposit', 'TransactionController@deposit');

    $router->get('balance', 'UserController@getBalance');

    $router->get('quotation/{coin}', 'CoinController@getQuotation');

    $router->post('buy/{coin}', 'CoinController@buy');
    $router->post('sell/{coin}', 'CoinController@sell');

    $router->get('portfolio', 'PortfolioController@get');
    $router->get('resume', 'TransactionController@get');
    $router->get('volume', 'TransactionController@getDailyVolume');
    $router->get('history', 'HistoryController@get');
});
