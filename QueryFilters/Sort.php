<?php
/**
 * https://laravelproject.com/laravel-filtering-query-using-pipelines/.
 * https://jeffochoa.me/understanding-laravel-pipelines.
 * https://dev.to/abrardev99/pipeline-pattern-in-laravel-278p.
 */

declare(strict_types=1);

namespace Modules\Xot\QueryFilters;

use Closure;
use Illuminate\Support\Facades\Request;

final class Sort
{
    /**
     * Undocumented function.
     */
    public function handle(Request $request, Closure $next): Closure
    {
        if (! request()->has('sort')) {
            return $next($request);
        }

        return $next($request)->orderBy('title', $request->input('sort'));
    }
}
