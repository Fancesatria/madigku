<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\OperatorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//yg ada middleware buat user aja kalo buat login
//operator dan admin gapake middleware auth
//admin dan operator dibuat group prrefix masing2-
//-biar gampang, gabanyak ketik

Route::prefix('admin')->group(function(){
    //ADMIN AUTH ----------------------
    Route::post('/register', 'AdminController@create');
    Route::post('/login', 'AdminController@login');
    Route::post('/edit/{id}', 'AdminController@update');
    Route::get('/del-auth/{id}', 'AdminController@destroy');
    Route::get('/show/{id}', 'AdminController@show');
    Route::get('/index', 'AdminController@index');


    //ADMIN KATEGORI ---------------------
    Route::prefix('kategori')->group(function(){
        Route::get('/index', 'KategoriController@index');
        Route::post('/add', 'KategoriController@create');
        Route::post('/edit/{id}', 'KategoriController@update');
        Route::get('/del/{id}', 'KategoriController@destroy');
        Route::get('/show/{id}', 'KategoriController@show');
    });

    //ADMIN KONTAK ---------------------
    Route::prefix('kontak')->group(function(){
        Route::get('/index', 'KontakController@index');
        Route::post('/add', 'KontakController@create');
        Route::post('/edit/{id}', 'KontakController@update');
        Route::get('/del/{id}', 'KontakController@destroy');
        Route::get('/show/{id}', 'KontakController@show');
    });

    //ADMIN EVENT ---------------------
    Route::prefix('event')->group(function(){
        Route::get('/index', 'EventController@index');
        Route::post('/add', 'EventController@create');
        Route::post('/edit/{id}', 'EventController@update');//kalo di put malah error
        Route::get('/del/{id}', 'EventController@destroy');
        Route::get('/show/{id}', 'EventController@show');
    });
});


Route::prefix('operator')->group(function(){
    //OPERATOR AUTH -------------------
    Route::post('/register', 'OperatorController@create');
    Route::post('/login', 'OperatorController@login');
    Route::post('/edit/{id}', 'OperatorController@update');
    Route::get('/index','OperatorController@index');
    Route::get('/show/{id}','OperatorController@show');
    Route::get('/del-auth/{id}', 'OperatorController@destroy');
});


Route::prefix('pengguna')->group(function(){
    //PENGGUNA AUTH -------------------------
    Route::post('/register', 'PenggunaController@create');
    Route::post('/login', 'PenggunaController@login');
    Route::post('/edit/{id}', 'PenggunaController@update');
    Route::post('/forgot-password', 'PenggunaController@forgot');
    Route::get('/index', 'PenggunaController@index');
    Route::get('/show/{id}', 'PenggunaController@show');
    Route::get('/del-auth/{id}', 'PenggunaController@destroy');
});

