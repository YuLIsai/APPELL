<?php

use App\Http\Controllers\alumnoController;
use App\Http\Controllers\maestroController;
use App\Http\Controllers\materiaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
   return view('welcome');
});

//Route::get('/', [alumnoController::class, 'index']);
//Route::get('/', [maestroController::class, 'index']);
//Route::get('/', [materiaController::class, 'index']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
