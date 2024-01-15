<?php

use Illuminate\Support\Facades\Route;

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
    return redirect()->to('/payment');
});
Route::get('view-logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Route::group(['prefix' => 'payment','namespace' => 'Payment'], function(){
    Route::get('','PaymentController@index')->name('get.payment.index');
    Route::get('create','PaymentController@create');
    Route::get('webhook','PaymentController@webhook')->name('get.payment.webhook');
    Route::post('create','PaymentController@store');
});