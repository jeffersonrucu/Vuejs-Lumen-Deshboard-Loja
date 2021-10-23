<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;

// table database
use App\Models\freddom_fashion_users;

class AuthController extends Controller
{
    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    protected function jwt(freddom_fashion_users $user) {
        $payload = [
            'iss' => 'lumen-jwt',
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + 500*500
        ];

        return JWT::encode($payload, env('JWT_SECRET'));
    }

    public function AuthenticateUser (freddom_fashion_users $user) {
        
        $this->validate($this->request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = freddom_fashion_users::where('email', $this->request->input('email'))->first();

        if(!$user) {
            return response()->json([
                'error' => 'E-mail não existe'
            ],400);
        }

        if(Hash::check($this->request->input('password'),$user->password)){
            $token= $this->jwt($user);

            $user->token = $token;
            $user->save();

            return response()->json([
                'token' => $token,
                'id' => $user->id
            ],200);
        }
        
        return response()->json([
            'error' => 'E-mail ou senha invalidos'
        ],400);
    }

    public function CheckToken () {
    }
}
