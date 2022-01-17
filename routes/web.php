<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TekoController;
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

Route::get('/outStock', [TekoController::class, 'outStock']);
Route::get('/temp2', [TekoController::class, 'tempFunc']);
Route::get('/', [TekoController::class, 'index']);
Route::get('/{id}', [TekoController::class, 'statistics']);
Route::get('/{id}/{mag}', [TekoController::class, 'torg3']);
Route::get('/{id}/{mag}/{grupa}', [TekoController::class, 'TM']);
Route::get('/{id}/{mag}/{grupa}/{TM}', [TekoController::class, 'product']);
Route::get('/{id}/{mag}/{grupa}/{TM}/{article}', [TekoController::class, 'remainder']);

