<?php

declare(strict_types=1);

namespace Modules\Xot\Http\Middleware;

/*
 * https://laravel.com/docs/8.x/urls#default-values
 */
use Illuminate\Http\Request;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;

/**
 * Class SetDefaultLocaleForUrlsMiddleware.
 */
final class SetDefaultLocaleForUrlsMiddleware
{
    /**
     * Handle the incoming request.
     */
    public function handle(Request $request, Closure $next): Response|JsonResponse|\Symfony\Component\HttpFoundation\Response
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
