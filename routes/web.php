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
        Route::get('/seed', ['as' => 'seed', 'uses' => 'WelcomeController@seed']);

        Route::get('/chunk', ['as' => 'chunk', 'uses' => 'ChunkController@chunk']);
        Route::get('/chunkBetter', ['as' => 'chunkb', 'uses' => 'ChunkController@chunkBetter']);
        Route::get('/chunkGotcha', ['as' => 'chunkg', 'uses' => 'ChunkController@chunkGotcha']);

        Route::get('/transact', ['as' => 'transact', 'uses' => 'TransactionController@transact']);

        Route::get('/single', ['as' => 'single', 'uses' => 'QueryController@single']);
        Route::get('/aggregate', ['as' => 'aggregate', 'uses' => 'QueryController@aggregate']);
        Route::get('/joins', ['as' => 'join', 'uses' => 'QueryController@joinGrouping']);
        Route::get('/subquery', ['as' => 'subquery', 'uses' => 'QueryController@subquery']);

      
      // - Eloquent Relationship Loading

    }
);