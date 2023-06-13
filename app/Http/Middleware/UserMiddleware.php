<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
            if(Auth::user()->level !== 'user'){
            if(Auth::user()->level === 'admin'){
                return redirect('/admin-dashboard');
            } else if(Auth::user()->level === 'pengurus'){
                return redirect('/pengurus-dashboard');
            } else {
                return redirect('/');
            }
        }
        } else {
            return redirect('/');
        }
        
        return $next($request);
    }
}
