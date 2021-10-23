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

/*
|--------------------------------------------------------------------------
| User Routes
|-------------------------------------------------------------------------- 
|
| user/{id}           ->  specific user
| user/register       ->  register user
| user/authentication ->  user authentication
| 
*/
$router->group(['middleware' => 'jwt.auth'], function () use ($router) {
    $router->get('/user/{id}',         'Users@SpecificUser');
});

$router->post('/user/register',        'Users@RegisterUser');
$router->post('/user/authentication',  'AuthController@AuthenticateUser');

/*
|--------------------------------------------------------------------------
| Product Routes
|-------------------------------------------------------------------------- 
|
| product/         ->  all products
| product/{id}     ->  specific product 
| product/register ->  register product
| product/modif    ->  modify product data
|
*/

$router->group(['middleware' => 'jwt.auth'], function () use ($router) {
    $router->post('/product/register',  'Products@RegisterProduct');
    $router->post('/product/modif',     'Products@ModifyProduct');
    $router->get('/products',           'Products@AllProduct');
    $router->get('/product/count',       'Products@CountProducts');
});
$router->get('/product/{barcode}',       'Products@SpecificProduct');
$router->post('/product/delete',     'Products@DeleteProduct');

/*
|--------------------------------------------------------------------------
| Clients Routes
|-------------------------------------------------------------------------- 
|
| clients/         ->  all gain
|
*/

$router->group(['middleware' => 'jwt.auth'], function () use ($router) {
    $router->get('/clients', 'Clients@AllClients');
    $router->post('/client/register', 'Clients@RegisterClient');
    $router->get('/client/specific',       'Clients@SpecificClient');
    $router->post('/client/modif',     'Clients@ModifyClient');
    $router->post('/client/delete',     'Clients@DeleteClient');
    $router->get('/clients/count',       'Clients@CountClients');

});

/*
|--------------------------------------------------------------------------
| Product Routes
|-------------------------------------------------------------------------- 
|
| sold/         ->  all sold
|
*/

$router->group(['middleware' => 'jwt.auth'], function () use ($router) {
    $router->post('/sold', 'Sold@SoldProduct');
    
});
$router->get('/sold/value',       'Sold@SoldMonth');
$router->get('/sold/count',       'Sold@CountSold');
$router->get('/sold/grafic/{year}',       'Sold@GraficSold');




/*
|--------------------------------------------------------------------------
| Filter / Search
|-------------------------------------------------------------------------- 
|
| search/   ->  search bar
|
*/

$router->post('/search',          'SearchBar@SearchMessage');

/*
|--------------------------------------------------------------------------
| Token
|-------------------------------------------------------------------------- 
|
| checktoken/  ->  check token
|
*/

$router->group(['middleware' => 'jwt.auth'], function () use ($router) {
    $router->get('/checktoken', 'AuthController@CheckToken');
});


$router->get('/', function () use ($router) {
    return $router->app->version();
});
