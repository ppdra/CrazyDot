<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $supported = config('locales.supported', ['pt_BR', 'en']);

        $locale = $request->query('lang')
            ?? $request->session()->get('lang')
            ?? $this->fromAcceptLanguage($request, $supported)
            ?? config('app.locale');

        if (! in_array($locale, $supported, true)) {
            $locale = config('app.fallback_locale');
        }

        App::setLocale($locale);
        $request->session()->put('lang', $locale);

        return $next($request);
    }

    private function fromAcceptLanguage(Request $request, array $supported): ?string
    {
        $header = (string) $request->header('Accept-Language', '');

        $first = strtolower(trim(explode(',', $header)[0] ?? ''));

        $map = [
            'pt-br' => 'pt_BR',
            'pt' => 'pt_BR',
            'en' => 'en',
            'en-us' => 'en',
        ];

        $candidate = $map[$first] ?? null;

        return $candidate && in_array($candidate, $supported, true) ? $candidate : null;
    }
}
