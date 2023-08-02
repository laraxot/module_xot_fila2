<?php

declare(strict_types=1);

namespace Modules\Xot\Traits;

/*
 * https://stackoverflow.com/questions/39213022/custom-laravel-relations
 * https://github.com/johnnyfreeman/laravel-custom-relation
 */

use Illuminate\Contracts\Database\Eloquent\Builder;
use Modules\Xot\Relations\CustomRelation;

// use Illuminate\Database\Eloquent\Builder;

/**
 * Trait HasCustomRelations.
 */
trait HasCustomRelations
{
    /**
     * @param Builder|string $related
     *
     * @return CustomRelation
     */
    public function customRelation($related, \Closure $baseConstraints, \Closure $eagerConstraints = null, \Closure $eagerMatcher = null)
    {
        $instance = new $related();
        // Call to an undefined method object::newQuery()
        $query = $instance->newQuery();

        return new CustomRelation($query, $this, $baseConstraints, $eagerConstraints, $eagerMatcher);
    }
}
