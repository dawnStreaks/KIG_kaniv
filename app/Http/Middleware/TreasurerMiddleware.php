<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TreasurerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'treasurer') {
            abort(403, 'Access denied. Treasurer role required.');
        }

        return $next($request);
    }
}