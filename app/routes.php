<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
/* first mode */
Route::get('/', function()
{
	return View::make('hello');
});

/* second mode
Route::get('users', 'users@index');
*/

Route::get('users', function()
{
	$users = User::all();
	return View::make('users')->with('users',$users);
});


/* third mode */
Route::get('test', function(){
	return 'TESTANDO OK!!!';
});
