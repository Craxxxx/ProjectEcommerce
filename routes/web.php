<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [Login::class, 'index'])->name('login');
