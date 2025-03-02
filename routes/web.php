<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/guest-login', function () {
    return redirect(backpack_url('dashboard')); // <--- Меняем redirect на backpack_url
})->name('guest.login');
