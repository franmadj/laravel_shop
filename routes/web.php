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
// Route::get('{any}', function () {
//     return view('admin/auth');
// })->whereIn('any', ['login', 'register']);


Route::get('/reset-password/{token}', function ($token) {
    return view('admin/index');
})->middleware('guest')->name('password.reset');


Route::get('{any}', function () {
    return view('admin/index');
})->where('any', '.*');
