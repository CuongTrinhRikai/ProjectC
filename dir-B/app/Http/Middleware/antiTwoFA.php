<?php

namespace App\Http\Middleware;

use Closure;
use Config;

class antiTwoFA
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
        if(Config::get('constants.TWOFA') == 1) {
            if(session()->get('verification_code') == session()->get('request_verification_code')) {
              return redirect("/".PREFIX."/home");
            } else {
                return $next($request);
            }
          } else {
            return redirect("/".PREFIX."/home");
        }
    }
}
