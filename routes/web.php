<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogisticsController;

Route::view('/', 'home.home')->name('home');
Route::get('/', function () {
    return view('welcome');
});
