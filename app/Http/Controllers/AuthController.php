<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request){

        // $credentials = $request->validate([
        //     'email'     => 'required|string|email',
        //     'password'  => 'required|string'
        // ]);
        // dd($credentials);
        // return $credentials;

        // if( !Auth::attempt($request->only('email', 'password')) ){
        //     return response()->json([
        //         'message' => 'Invalid login details'
        //     ],401);
        // }

        // $userdata = array( 'email' => $credentials['email'], 'password' => $credentials['password'] );
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
