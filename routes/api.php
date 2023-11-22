<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\BoardGameController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Login routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Registration routes
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// User profile route
    Route::get('/profile', [AuthController::class, 'getUserProfile']);
    Route::put('/update-profile', [AuthController::class, 'updateUserProfile']);
    Route::delete('/delete-account', [AuthController::class, 'deleteAccount']);

  // Forum routes
  Route::prefix('/forums')->group(function () {
    Route::get('/threads', [ForumController::class, 'index']); // Display all threads
    Route::get('/threads/{id}', [ForumController::class, 'show']); // Display a specific thread
    Route::post('/threads', [ForumController::class, 'store']); // Create a new thread
    Route::put('/threads/{id}', [ForumController::class, 'update']); // Update a specific thread
    Route::delete('/threads/{id}', [ForumController::class, 'destroy']); // Delete a specific thread
});

    // Board games routes
    Route::prefix('/board-games')->group(function () {
        Route::get('/', [BoardGameController::class, 'index']);
        Route::get('/{id}', [BoardGameController::class, 'show']);
        Route::post('/', [BoardGameController::class, 'store']);
        Route::put('/{id}', [BoardGameController::class, 'update']);
        Route::delete('/{id}', [BoardGameController::class, 'destroy']);
    });

