<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController; 
use App\Http\Controllers\Api\CommentController; // <<< INI YANG DITAMBAH

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// --- 1. ROUTE TANPA AUTENTIKASI (Public Endpoints) ---
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

// Post index() dan show() publik
Route::get('/posts', [PostController::class, 'index']);      // Tampilkan semua post
Route::get('/posts/{post}', [PostController::class, 'show']); // Tampilkan detail post


// --- 2. ROUTE DENGAN AUTENTIKASI (Protected Endpoints) ---
Route::middleware('auth:sanctum')->group(function () {
    
    // Endpoint untuk User yang sedang login
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Endpoint untuk Logout
    Route::post('/logout', [UserController::class, 'logout']); 

    // Endpoint CRUD Posts yang butuh otorisasi (store, update, destroy)
    Route::resource('posts', PostController::class)->only([
        'store', 'update', 'destroy'
    ]);
    
    // >>> ROUTE KHUSUS UNTUK KOMENTAR <<<
    // POST /api/posts/{post}/comments - Membuat komentar baru di post tertentu
    Route::post('/posts/{post}/comments', [CommentController::class, 'store']);
    
    // DELETE /api/comments/{comment} - Menghapus komentar berdasarkan ID komentar
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);
});
