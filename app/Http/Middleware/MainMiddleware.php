<?php

namespace App\Http\Middleware;

use App\Factories\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MainMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $headers = $request->header('Authorization');

        if (isset($headers)) {
            $token = explode(' ', $headers)[1];
            $response = Auth::validateBearerToken($token);
            if ($response['success'])
                return $next($request);
        } else if ($request->path() == 'api/v1/auth/login' && $request->method() == 'POST') {
            return $next($request);
        } else {
            return response()->json(['success' => false, 'message' => 'Acceso no autorizado'], 401);
        }
    }
}
