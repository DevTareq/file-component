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

//@todo make a group for files
// @todo csrf for the form
$router->get('/files', 'FileController@index');
$router->post('/files/upload', 'FileController@upload');
$router->post('/files/upload-api', 'FileController@uploadApi');
