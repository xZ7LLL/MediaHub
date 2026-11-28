<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function connecter(Request $request)
    {
        $identifiants = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $utilisateur = User::where('email', $identifiants['email'])->first();

        if (! $utilisateur || ! Hash::check($identifiants['password'], $utilisateur->password)) {
            return response()->json(['message' => 'Identifiants incorrects.'], 401);
        }

        $jeton = $utilisateur->createToken('api')->plainTextToken;

        return response()->json(['token' => $jeton]);
    }
}