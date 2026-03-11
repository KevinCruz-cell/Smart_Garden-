<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/principal', function () {
    return view('principal');
})->name('home');

Route::get('/registro', function () {
    return view('registro');
})->name('home');

Route::get('/sesion', function () {
    return view('sesion');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('home');

Route::get('/cultivos', function () {
    return view('cultivos');
})->name('home');

Route::get('/siembras', function () {
    return view('siembras');
})->name('home');

Route::get('/monitoreo', function () {
    return view('monitoreo');
})->name('home');

Route::get('/alertas', function () {
    return view('alertas');
})->name('home');

Route::get('/reportes', function () {
    return view('reportes');
})->name('home');

Route::get('/cosechas', function () {
    return view('cosechas');
})->name('home');







Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');
