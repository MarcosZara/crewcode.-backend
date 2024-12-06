<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function register(Request $request)
{
    $request->validate([
        'username' => 'required|string|max:50|unique:users',
        'level' => 'nullable|string',
        'password' => 'required|string|min:6',
        'bio' => 'nullable|string',
        'interests' => 'nullable|string'
    ]);


    if (User::where('username', $request->username)->exists()) {
        return response()->json(['error' => 'Este usuario ya ha sido registrado'], 409); // Código de conflicto
    }

    $user = new User([
        'username' => $request->username,
        'level' => $request->level,
        'password' => Hash::make($request->password),
        'bio' => $request->bio,
        'interests' => $request->interests
    ]);

    $user->save();

    return response()->json(['message' => 'Usuario registrado con éxito'], 201);
}

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');


        $user = User::where('username', $credentials['username'])->first();
        if (!$user) {
            return response()->json(['error' => 'Introduzca un usuario válido'], 404);
        }


        if (!Hash::check($credentials['password'], $user->password)) {
            return response()->json(['error' => 'La contraseña es incorrecta'], 401);
        }


        $token = $user->createToken('access-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }



}
