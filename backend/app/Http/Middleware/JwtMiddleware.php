<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

// table database
use App\Models\freddom_fashion_users;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $id = $request->header('id');
        $token = $request->header('token');
        
        if (!$token) {
            return response()->json([
                'error' => 'Sessão expirado',
            ],400);
        }

        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch(ExpiredException $e){
            return response()->json([
                'error' => 'Sessão expirado'
            ],400);
        } catch(Exception $e) {
            return response()->json([
                'error' => 'Sessão expirado'
            ],400);
        }

        $userVerific = freddom_fashion_users::find($id);
        if ($userVerific->token === $token) {
            
            $user = freddom_fashion_users::find($credentials->sub);
            $request->auth = $user;

            return $next($request);
        } else {
            return response()->json([
                'error' => 'Token Invalido'
            ],400);
        }

    }
}
