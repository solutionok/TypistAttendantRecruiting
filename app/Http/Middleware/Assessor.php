<?php

namespace App\Http\Middleware;

use Closure;

class Assessor
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
        if(auth()->user()->isadmin > 0){
            return $next($request);
        }

        return redirect('/');
    }
}
