<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/import', [UserController::class, 'showForm']);
Route::post('/import', [UserController::class, 'import'])->name('import');
Route::get('/export', [UserController::class, 'export'])->name('export');

Route::get('/',[UserController::class, 'showUsers']);
