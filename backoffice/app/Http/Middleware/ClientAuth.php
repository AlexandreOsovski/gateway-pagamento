<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ClientAuth
{
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::guard('client')->check() || Auth::guard('web')->check()) {

            return $next($request);
        }

        return redirect()->route('login.get');
    }
}
