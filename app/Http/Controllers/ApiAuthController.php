<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use JWTAuth;
use Hash;
use App\Http\Requests;

class ApiAuthController extends Controller
{
    public function authenticate(Request $request) {
        if(!$request->has('email') || !$request->has('password')) {
            return response()->json([
              'error' => "Credenciais inválidas. Por favor envie os parametros 'email' e 'password' corretamente."
            ], 401);
        }

        $credentials = $request->only('email', 'password');
  
        $user = User::where('email', $credentials['email'])->first();
  
        if(!$user) {
            return response()->json([
                'error' => 'Usuário não encontrado com este email.'
            ], 401);
        }
  
        if (!Hash::check($credentials['password'], $user->password)) {
            return response()->json([
              'error' => 'Senha inválida.'
            ], 401);
        }
  
        $token = JWTAuth::fromUser($user);
  
        $objectToken = JWTAuth::setToken($token);
        $expiration = JWTAuth::decode($objectToken->getToken())->get('exp');
  
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::decode($objectToken->getToken())->get('exp')
        ]);
    }
}
