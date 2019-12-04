<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', 'WelcomeController@index');
// Route::get('/', 'HomeController@index');
// Route::get('home', 'HomeController@index');

Route::get('/', 'mainController@index');
// Route::get('home', 'HomeController@index');

//Import
Route::get('import', 'importController@index');
Route::post('postImportpallet', 'importController@postImportpallet');

//Pallet
Route::get('/pallet', 'palletController@index');
Route::get('/pallet_new', 'palletController@create');
Route::post('/pallet_insert', 'palletController@insert');
Route::get('/pallet/edit/{id}', 'palletController@edit');
Route::post('/pallet/{id}', 'palletController@update');
Route::get('/pallet/delete/{id}', 'palletController@delete');
Route::post('/pallet/delete/{id}', 'palletController@delete');

//Stock
Route::get('/cbstock', 'stockController@index');
Route::get('add_to_stock', 'stockController@add_to_stock');
Route::post('select_pallet', 'stockController@select_pallet');
Route::post('scanncb', 'stockController@scanncb');
Route::post('scannlist', 'stockController@scannlist');
Route::get('/cb/edit/{id}', 'stockController@edit');
Route::post('/cb/{id}', 'stockController@update');
Route::post('/cb/delete/{id}', 'stockController@delete');

//Ship
Route::get('/cbship', 'shipController@index');
Route::get('scan_to_shipment', 'shipController@scan_to_shipment');
Route::post('scanncb_ship', 'shipController@scanncb');
Route::post('scannlist_ship', 'shipController@scannlist');
Route::get('/cb_ship/edit/{id}', 'shipController@edit');
Route::post('/cb_ship/{id}', 'shipController@update');
Route::post('/cb_ship/delete/{id}', 'shipController@delete');
Route::get('/post_shipment', 'shipController@post_shipment');
Route::post('/confirm_shipment', 'shipController@confirm_shipment');

Route::get('/cbship_log', 'shipController@index_log');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
