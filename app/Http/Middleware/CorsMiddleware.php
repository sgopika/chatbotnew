<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CorsMiddleware {
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Allow requests from WordPress IP
        $response->headers->set('Access-Control-Allow-Origin', '*'); 
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        // Handle preflight (OPTIONS) request
        if ($request->isMethod('OPTIONS')) {
            return response()->json('OK', 200, $response->headers->all());
        }

        return $response;
    }
}
