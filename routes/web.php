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

Route::get('dang-nhap',[\App\Http\Controllers\Auth\AuthController::class,'login'])->name('get.login');
Route::post('dang-nhap',[\App\Http\Controllers\Auth\AuthController::class,'postLogin'])->name('post.login');
Route::get('dang-xuat',[\App\Http\Controllers\Auth\AuthController::class,'logout'])->name('get.logout');
Route::get('quen-mat-khau',[\App\Http\Controllers\Auth\AuthController::class,'restartPassword'])->name('get.restart_password');
Route::post('quen-mat-khau',[\App\Http\Controllers\Auth\AuthController::class,'checkRestartPassword']);

Route::get('thong-bao-cap-khau-moi',[\App\Http\Controllers\Auth\AuthController::class,'alertNewPassword'])->name('get.alert_new_password');
Route::get('mat-khau-moi',[\App\Http\Controllers\Auth\AuthController::class,'newPassword'])->name('get.new_password');
Route::post('mat-khau-moi',[\App\Http\Controllers\Auth\AuthController::class,'processNewPassword']);

Route::get('dang-ky',[\App\Http\Controllers\Auth\AuthController::class,'register'])->name('get.register');
Route::post('dang-ky',[\App\Http\Controllers\Auth\AuthController::class,'postRegister'])->name('post.register');
Route::get('/', function () {
    return view('welcome');
//    return redirect()->to('/payment');
});
Route::get('view-logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Route::get('transactions', [\App\Http\Controllers\Payment\PaymentController::class, 'index']);
Route::group(['prefix' => 'payment','namespace' => 'Payment'], function(){
    Route::get('','PaymentController@index')->name('get.payment.index');
    Route::get('create','PaymentController@create');
    Route::get('webhook','PaymentController@webhook')->name('get.payment.webhook');
    Route::post('create','PaymentController@store');
});

Route::get('create-transaction', [\App\Http\Controllers\PayPalController::class, 'createTransaction'])->name('createTransaction');
Route::get('process-transaction', [\App\Http\Controllers\PayPalController::class, 'processTransaction'])->name('processTransaction');
Route::get('success-transaction', [\App\Http\Controllers\PayPalController::class, 'successTransaction'])->name('successTransaction');
Route::get('cancel-transaction', [\App\Http\Controllers\PayPalController::class, 'cancelTransaction'])->name('cancelTransaction');