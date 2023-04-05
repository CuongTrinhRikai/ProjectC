<?php

namespace App\Http\Middleware\Frontend;

use Closure;

class Language
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
        $locale = $request->header('locale') ?? 'en';
        app()->setlocale($locale);
        return $next($request);
    }
}
