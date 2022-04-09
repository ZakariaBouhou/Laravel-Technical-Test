<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {

            if (Auth::user()->role === 'ROLE_USER') {

                return redirect(route('myprofil', [Auth::user()->id]));

            }

            else if (Auth::user()->role === 'ROLE_ADMIN') {

                return $next($request);

            }

            abort(403, 'L\'accès à cette page n\'est pas autorisée');

        }

    }
}
