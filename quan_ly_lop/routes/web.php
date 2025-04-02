<?php

use Illuminate\Support\Facades\Route;

/* STUDENT */
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

/* LECTURER */
Route::get('/homepage_lecture', function () {
    return view('lecturerViews.homepage_lecture');
})->name('homepage_lecture');
Route::get('/create_questionBank', function () {
    return view('lecturerViews.question_bank');
})->name('create_questionBank');

