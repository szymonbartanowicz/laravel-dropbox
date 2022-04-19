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

Auth::routes();

Route::get('/webhook', 'WebhookController@init');
Route::post('/webhook', 'WebhookController@process');

Route::middleware('auth')->group(function () {
    Route::get('/connect', 'CustomerController@connect')->name('connect');
    Route::get('/setDbxCredentials', 'CustomerController@setDbxCredentials');

    Route::get('/', 'FileController@index')->name('home');
    Route::get('/download', 'FileController@download')->name('download');
    Route::post('/deleteFile', 'FileController@deleteFile')->name('deleteFile');
    Route::post('/deleteDir', 'FileController@deleteDir')->name('deleteDir');
    Route::get('/createDir', function () {
        return view('createDir');
    })->name('showCreateDir');
    Route::post('/createDir', 'FileController@createDir')->name('createDir');
    Route::get('/uploadFile', function () {
        return view('uploadFile');
    })->name('showUploadFile');
    Route::post('/uploadFile', 'FileController@uploadFile')->name('uploadFile');
});

