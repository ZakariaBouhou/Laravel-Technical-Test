<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
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

/*  A revoir ! 
    - L'optimisation des routes et des controlleurs
    - L'utilisation de Gate pour les controles d'accès (Chaque utilisateur peut avoir accès au profil de l'autre, pas bon du tout)
*/

// UserController : Page d'accueil (formulaire de connexion), Page d'inscription, d'édition, de profil et de suppression
Route::post('/', [UserController::class, 'connexion'])->middleware('guest');

Route::get('/register', [UserController::class, 'register'])->name('register')->middleware(('guest'));

Route::post('/register', [UserController::class, 'create'])->middleware('guest');

Route::get('/profil/{id}', [UserController::class, 'show'])->whereNumber('id')->name('myprofil')->middleware('auth');

Route::get('/profil/{id}/edit', [UserController::class, 'edit'])->whereNumber('id')->name('edit')->middleware('auth');

Route::post('/profil/{id}/update', [UserController::class, 'update'])->whereNumber('id')->name('update')->middleware('auth');

Route::get('/profil/{id}/delete', [UserController::class, 'delete'])->whereNumber('id')->name('delete')->middleware('auth');


// LoginController : Page de connexion, déconnexion
Route::get('/', [LoginController::class, 'login'])->name('login')->middleware('guest');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');


// AdminController : Page de suppression forcée d'un utilisateur, bo avec liste des utilisateurs, formulaire de création utilisateur
Route::get('/profil/{id}/delete/force', [AdminController::class, 'forceDelete'])->whereNumber('id')->name('forceDelete')->middleware(['auth', 'admin']);

Route::get('/admin', [AdminController::class, 'browse'])->name('browse')->middleware(['auth', 'admin']);

Route::get('/admin/create/user', [AdminController::class, 'createView'])->name('createView')->middleware(['auth', 'admin']);

Route::post('/admin/create/user', [AdminController::class, 'create'])->name('create')->middleware(['auth', 'admin']);




