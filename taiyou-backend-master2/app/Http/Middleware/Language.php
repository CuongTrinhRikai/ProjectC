<?php

namespace App\Http\Middleware;

use App\Services\System\LanguageService;
use Closure;
use Illuminate\Support\Facades\View;
use Config;
use Cookie;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function __construct(LanguageService $languageService)
    {
        $this->languageService = $languageService;
    }
    public function handle($request, Closure $next)
    {
        if (Cookie::get('lang') !== null) {
            $locale = Cookie::get('lang');
        } elseif (session()->get('lang') !== null) {
            $locale = session()->get('lang');
        } else {
            $locale = Config::get('constants.DEFAULT_LOCALE');
        }
        app()->setlocale($locale);
        View::share('globalLocale', $locale);

     
        return $next($request);
    }
}
