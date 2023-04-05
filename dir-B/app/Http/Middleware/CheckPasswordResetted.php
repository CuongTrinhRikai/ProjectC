<?php

namespace App\Http\Middleware;

use Closure;

class CheckPasswordResetted
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
        if(authUser()->password_resetted == 0){
            return redirect(route('change.password'));
        }
        return $next($request);
    }
}
