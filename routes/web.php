<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\UserController;
use App\Models\Utilisateurs;
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

Route::get('/', [UserController::class, 'login'])->name('login')->middleware('guest');

Route::post('/', [UserController::class, 'connexion'])->middleware('guest');

Route::get('/register', [UserController::class, 'register'])->name('register')->middleware(('guest'));

Route::post('/register', [UserController::class, 'userForm'])->middleware('guest');

Route::get('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/profil/{id}', [UserController::class, 'show'])->whereNumber('id')->name('myprofil')->middleware('auth');

Route::get('/profil/{id}/edit', [UserController::class, 'edit'])->whereNumber('id')->name('edit')->middleware('auth');

Route::post('/profil/{id}/update', [UserController::class, 'update'])->whereNumber('id')->name('update')->middleware('auth');

Route::get('/profil/{id}/delete', [UserController::class, 'delete'])->whereNumber('id')->name('delete')->middleware('auth');


Route::get('/profil/{id}/delete/force', [AdminController::class, 'forceDelete'])->whereNumber('id')->name('forceDelete')->middleware(['auth', 'admin']);

Route::get('/admin', [AdminController::class, 'browse'])->name('browse')->middleware(['auth', 'admin']);

Route::get('/admin/create/user', [AdminController::class, 'createView'])->name('createView')->middleware(['auth', 'admin']);

Route::post('/admin/create/user', [AdminController::class, 'create'])->name('create')->middleware(['auth', 'admin']);




