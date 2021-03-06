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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function()
{
	Route::group(['prefix' => 'produtos'], function()
	{
		Route::get('buscar-por-sku', 'ProductsController@checkProductBySku');
		Route::get('verifica-estoque/{id}', 'ProductsController@verifyStock');
		Route::get('cadastrar', 'ProductsController@add');
		Route::get('editar/{id}', 'ProductsController@edit');
		Route::get('excluir/{id}', 'ProductsController@delete');
		Route::get('restaurar/{id}', 'ProductsController@restore');
		Route::post('salvar/{id?}', 'ProductsController@save');
		Route::get('', 'ProductsController@list');
	});

	Route::group(['prefix' => 'estoque'], function()
	{
		Route::get('adicionar', 'StockController@add');
		Route::post('adicionar', 'StockController@changeStockAdd');
		Route::get('dar-baixa', 'StockController@remove');
		Route::post('dar-baixa', 'StockController@changeStockRemove');
	});

	Route::group(['prefix' => 'relatorios'], function()
	{
		Route::get('', 'LogsController@list');
	});
});