<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;

class Check2FA
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('user_2fa')) {
            return redirect()->route('2fa.index');
        }

        return $next($request);
    }
}
