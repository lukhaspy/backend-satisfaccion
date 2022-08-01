<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function logout()
    {
        auth()->user()->tokens()->delete();
    }
    public function userProfile()
    {
        return response()->json(auth()->user());
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:usuario,email',
            'password' => 'required',
        ]);

        $usuario = User::where('email', $request->email)->first();


        if (!Hash::check(trim($request->password), $usuario->password)) {
            return response()->json(['errors' => ['Contraseña Inválida']], 500);
        }

        $usuario->tokens()->delete();


        // Crear token
        $token = $usuario->createToken('auth_token')->plainTextToken;
        $resp = ['message' => 'Login exitoso', 'data' =>
        [
            'session_token' => $token,

        ]];

        return response()->json($resp, 200);
    }
}
