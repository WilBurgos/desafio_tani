<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request){
        if( Auth::attempt($request->only('email', 'password')) ){
            $token = auth()->user()->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer'
            ],200);
        }else{
            return response()->json([
                'message' => 'Credenciales inválidas'
            ],401);
        }
    }
}
