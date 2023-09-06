<?php
/**
 * https://laravelproject.com/laravel-filtering-query-using-pipelines/.
 * https://jeffochoa.me/understanding-laravel-pipelines.
 * https://dev.to/abrardev99/pipeline-pattern-in-laravel-278p.
 */

declare(strict_types=1);

namespace Modules\Xot\QueryFilters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * Undocumented class.
 */
class Search
{
    /**
     * Undocumented function.
     */
    public function handle(Builder $builder, Closure $next, array ...$args): Closure
    {
        $search_fields = [];
        $model = $builder->getModel();
        $q = request('q', '');

        $search_fields = $model->getFillable();
        // $table = $model->getTable();
        if (\strlen($q) > 1) {
            $builder = $builder->where(
                function ($subquery) use ($search_fields, $q): void {
                    foreach ($search_fields as $search_field) {
                        if (Str::contains($search_field, '.')) {
                            [$rel, $rel_field] = explode('.', $search_field);

                            // dddx([$rel, $rel_field]);
                            $subquery = $subquery->orWhereHas(
                                $rel,
                                function (Builder $builder) use ($rel_field, $q): void {
                                    // dddx($subquery1->getConnection()->getDatabaseName());

                                    $builder->where($rel_field, 'like', '%'.$q.'%');
                                    // dddx($subquery1);
                                }
                            );

                            // dddx($subquery);
                        } else {
                            $subquery = $subquery->orWhere($search_field, 'like', '%'.$q.'%');
                        }
                    }
                }
            );
        }
        // dddx(['q' => $q, 'sql' => $query->toSql()]);

        return $next($builder);
    }
}
