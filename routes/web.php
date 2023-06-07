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

$router->get('/list/{id}', 'ListController@show');
$router->post('/list/add', 'ListController@add');
$router->post('/list/add_products/{id}', 'ListController@add_products');
$router->post('/list/remove_products/{id}', 'ListController@remove_products');
$router->post('/list/change/{id}', 'ListController@change');
