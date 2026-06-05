<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    private const SUPPORTED = ['ar', 'en'];

    public function handle(Request $request, Closure $next): Response
    {
        // Locale is driven by the URL so each language has its own crawlable
        // address (/ = Arabic, /en = English). This is what lets Google index
        // both languages instead of a single session-dependent page.
        $locale = $request->segment(1) === 'en' ? 'en' : 'ar';

        if (! in_array($locale, self::SUPPORTED, true)) {
            $locale = 'ar';
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
