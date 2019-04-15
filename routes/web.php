<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(
    [
      'as' => 'home::',
      'namespace' => 'Home',
    ],
    function () {

        Route::get('/', ['as' => 'home', 'uses' => 'WelcomeController@welcome']);
        Route::get('/user', ['as' => 'user', 'uses' => 'WelcomeController@user']);
        Route::get('/seed', ['as' => 'user', 'uses' => 'WelcomeController@seed']);


        Route::get('/chunk', ['as' => 'user', 'uses' => 'ChunkController@chunk']);

    }
);