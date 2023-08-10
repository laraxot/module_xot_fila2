<?php

declare(strict_types=1);

namespace Modules\Xot\Http\Middleware;

/*
 * https://laravel.com/docs/8.x/urls#default-values
 */

use Illuminate\Support\Facades\URL;

/**
 * Class SetDefaultLocaleForUrlsMiddleware.
 */
class SetDefaultLocaleForUrlsMiddleware
{
    /**
     * Handle the incoming request.
     */
    public function handle(\Illuminate\Http\Request $request, \Closure $next): \Illuminate\Http\Response
    {
        URL::defaults(
            [
                'lang' => app()->getLocale(),
                // 'referrer' => url()->previous(),
            ]
        );

        return $next($request);
    }
}
