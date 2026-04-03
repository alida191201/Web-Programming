<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MangaController;
use App\Http\Controllers\ContactController;

Route::get('/', [HomeController::class, 'index'])->name('home');


// Rotte Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Rotte Register
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Rotta Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/manga', [App\Http\Controllers\MangaController::class, 'index'])->name('manga.index');
Route::post('/manga/{id}/like', [App\Http\Controllers\MangaController::class, 'like'])->name('manga.like');
Route::post('/manga/{id}/comment', [App\Http\Controllers\MangaController::class, 'comment'])->name('manga.comment');



Route::get('/contatti', [ContactController::class, 'index'])->name('contacts');
Route::post('/contatti', [ContactController::class, 'store'])->name('contacts.store');
Route::post('/contacts', [ContactController::class, 'send'])->middleware('auth');



Route::get('/top', [AnimeController::class, 'index'])->name('anime.top');


Route::post('/anime/{id}/like', [AnimeController::class, 'like'])->name('anime.like');
Route::post('/anime/{id}/comment', [AnimeController::class, 'comment'])->name('anime.comment');


Route::get('/anime/{id}/stats', [AnimeController::class, 'stats'])->name('anime.stats');
Route::get('/anime/{id}/comments', [App\Http\Controllers\AnimeController::class, 'getComments'])
    ->name('anime.comments');

