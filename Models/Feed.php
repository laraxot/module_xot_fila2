<?php

declare(strict_types=1);

namespace Modules\Xot\Models;

// --- services

// --- TRAITS ---

/**
 * Modules\Xot\Models\Feed.
 *
 * @method static \Modules\Xot\Database\Factories\FeedFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Feed  newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feed  newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feed  query()
 * @mixin \Eloquent
 * @mixin IdeHelperFeed
 */
class Feed extends BaseModel
{
    /**
     * @var string[]
     */
    protected $fillable = ['id', 'created_at', 'updated_at'];
}
