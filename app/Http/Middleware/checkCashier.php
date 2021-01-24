<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class checkCashier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if(Auth::user()->roles->first()->name == 'Staff'){
                return redirect()->route('products.index');
            }
            return $next($request);
        }
        return redirect()->route('welcome');
    }
}
