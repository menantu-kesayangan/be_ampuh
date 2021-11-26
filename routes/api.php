<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


//Route Ambil Data dari THINGSPEAK
Route::get('thingspeak', 'AmbilController@index'); //ambil seluruh data di thingspeak
Route::get('suhu', 'AmbilController@suhu'); //ambil data suhu (max, min, avg & grafik)
Route::get('saturasi', 'AmbilController@saturasi'); //ambil data saturasi (max, min, avg & grafik)
Route::get('jmlhpengunjunghariini', 'AmbilController@jmlhpengunjunghariini'); //jumlah pengunjung hari ini
Route::get('jmlhpengunjungmingguini', 'AmbilController@jmlhpengunjungmingguini'); //jumlah pengunjung minggu ini
Route::get('jmlhpengunjungbulanini', 'AmbilController@jmlhpengunjungbulanini'); //jumlah pengunjung bulan ini
Route::get('cairan', 'AmbilController@cairan'); //ambil data cairan handsanitizer
Route::get('grafikpengunjung', 'AmbilController@grafikpengunjung'); // ambil data x dan y untuk grafik pengunjung


//Route Pengguna
Route::get('pengguna', 'PenggunaController@index'); //get all data pengguna
Route::post('pengguna', 'PenggunaController@create'); //create admin
Route::put('pengguna/{id}', 'PenggunaController@update'); //update profile admin
Route::delete('pengguna/{id}', 'PenggunaController@delete'); //delete admin
