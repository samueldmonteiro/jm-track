<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class DetectUserType
{
    public function handle($request, Closure $next)
    {
        try {
            $token = JWTAuth::parseToken();
            $payload = $token->getPayload();

            if ($payload->get('role') === 'admin') {
                auth()->shouldUse('admin');
            } elseif ($payload->get('role') === 'company') {
                auth()->shouldUse('company');
            } else {
                return response()->json(['error' => 'Tipo de usuário inválido'], 403);
            }

            return $next($request);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token inválido'], 401);
        }
    }
}
