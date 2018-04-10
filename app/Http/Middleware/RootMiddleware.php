<?php

namespace App\Http\Middleware;

use Closure;

class RootMiddleware
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
        if(session('job') != 'Root'){
            return redirect('/forbidden');
        }
        return $next($request);
    }
}
