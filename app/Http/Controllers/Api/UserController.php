<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Mendaftarkan user baru.
     */
    public function register(Request $request)
    {
        // Validasi data input, termasuk min:8 dan confirmed untuk password
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Wajib hashing password!
        ]);

        // Buat token Sanctum untuk user
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil. Selamat datang!',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201); // 201 Created untuk registrasi
    }

    /**
     * Otentikasi user dan buat token.
     */
    public function login(Request $request)
    {
        // Validasi data input login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Coba otentikasi
        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['Kredensial yang Anda masukkan tidak cocok dengan catatan kami.'],
            ]);
        }

        $user = $request->user();
        
        // Hapus token lama dan buat token baru untuk keamanan
        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil.',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }
    
    /**
     * Logout user dengan menghapus semua token.
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        
        return response()->json(['message' => 'Logout berhasil. Token dihapus.'], 200);
    }
}
