<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();

        // cek user ada n pw cocok
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Username atau password salah!'
            ], 401);
        }

        // buat token akses 
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil, halo ' . $user->username,
            'data' => [
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer'
            ]
        ]);
    }

    public function logout(Request $request)
    {
        // delete token yang sedang digunakan
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil logout, ' . $request->user()->username
        ]);
    }
    // admin mendaftarkan anak kandang baru
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'role'     => 'required|in:Admin,Anak_Kandang'
        ]);

        $user = User::create([
            'username' => $request->username,
            // pw  di enkripsi (di hash) biar ga kelihatan di db
            'password' => Hash::make($request->password), 
            'role'     => $request->role,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User baru berhasil ditambahkan!',
            'data' => $user
        ]);
    }
}

