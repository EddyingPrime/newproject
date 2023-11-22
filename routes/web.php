<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardGameController;

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

Route::get('/boardgames/add', function () {
    return view('/boardgames/add');
});


Route::get('/boardgames/add', [BoardGameController::class, 'create'])->name('boardgames.add');
Route::post('/boardgames', [BoardGameController::class, 'store'])->name('boardgames.store');
