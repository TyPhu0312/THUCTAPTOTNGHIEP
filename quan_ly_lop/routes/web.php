<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('homepage');
})->name('home');
Route::get('/myclass', function () {
    return view('myclass');
})->name('myclass');
Route::get('/account', function () {
    return view('account');
})->name('account');
Route::get('/todopage', function () {
    return view('todopage');
})->name('todopage');

