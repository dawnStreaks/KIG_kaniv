<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CenterMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->user_type !== 'center') {
            abort(403, 'Access denied. Center user required.');
        }

        return $next($request);
    }
}