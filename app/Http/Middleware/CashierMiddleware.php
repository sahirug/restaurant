<?php

namespace App\Http\Middleware;

use Closure;

class CashierMiddleware
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
        if(session('job') != 'Cashier'){
            return redirect('forbidden');
        }
        return $next($request);
    }
}
