<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use App;

class LocaleMiddleware
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
        //$raw_locale = Session::get('locale');
        $raw_locale = $request->session()->get('locale');
        $url_locale = $request->locale;
        if (in_array($url_locale, Config::get('app.locales'))) {
            $locale = $url_locale;
            session(['locale' => $locale]);
        }
        else if (in_array($raw_locale, Config::get('app.locales'))) {
            $locale = $raw_locale;
        }
        else 
            $locale = Config::get('app.locale');

        App::setLocale($locale);
        
        return $next($request);
    }
}
