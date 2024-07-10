<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DisableCSRF
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

     protected $except = [
        'forms', // Add your routes here
    ];

    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }
}
