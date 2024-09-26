<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (is_null(\Auth::user()) ||
            \Auth::user() != null && !\Auth::user()->is_admin) {
            abort(403, 'Accesso negato: Non hai i permessi per accedere a questa risorsa');
        }
        return $next($request);
    }
}
