<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App;
use Config;

class apiSetLang
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
        $lang = $request->header('lang');
        $lang = $lang == null ? 'en' : $lang;
        App::setLocale($lang);

        return $next($request);
    }
}
