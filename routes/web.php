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
        Route::get('/chunk/better', ['as' => 'chunkb', 'uses' => 'ChunkController@chunkBetter']);
        Route::get('/chunk/gotcha', ['as' => 'chunkg', 'uses' => 'ChunkController@chunkGotcha']);

        Route::get('/transact', ['as' => 'transact', 'uses' => 'TransactionController@transact']);

        Route::get('/query/single', ['as' => 'single', 'uses' => 'QueryController@single']);
        Route::get('/query/aggregate', ['as' => 'aggregate', 'uses' => 'QueryController@aggregate']);
        Route::get('/query/joins', ['as' => 'join', 'uses' => 'QueryController@joinGrouping']);
        Route::get('/query/subquery', ['as' => 'subquery', 'uses' => 'QueryController@subquery']);


        Route::get('relationship/seed', ['as' => 'rel::seed', 'uses' => 'RelationshipController@seed']);
        Route::get('relationship/emails', ['as' => 'rel::emails', 'uses' => 'RelationshipController@emails']);
        Route::get('relationship/eagerEmails', ['as' => 'rel::eagerEmails', 'uses' => 'RelationshipController@eagerEmails']);
        Route::get('relationship/eagerJoin', ['as' => 'rel::eagerEmails', 'uses' => 'RelationshipController@eagerJoin']);

    }
);