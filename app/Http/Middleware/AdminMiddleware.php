<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{

    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $next($request);
        }

        return  response()->json([
            "message" => "You don't have permission to do this.",
            "code" => Response::HTTP_FORBIDDEN,
            "data" => null,
            "success" => false,
        ]);
    }
}
