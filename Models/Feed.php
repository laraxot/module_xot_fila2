<?php

declare(strict_types=1);

namespace Modules\Xot\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Xot\Database\Factories\FeedFactory;

// --- services
// --- TRAITS ---
/**
 * Modules\Xot\Models\Feed.
 *
 * @method static FeedFactory  factory($count = null, $state = [])
 * @method static Builder|Feed newModelQuery()
 * @method static Builder|Feed newQuery()
 * @method static Builder|Feed query()
 *
 * @mixin IdeHelperFeed
 *
 * @property int         $id
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|Feed whereCreatedAt($value)
 * @method static Builder|Feed whereCreatedBy($value)
 * @method static Builder|Feed whereId($value)
 * @method static Builder|Feed whereUpdatedAt($value)
 * @method static Builder|Feed whereUpdatedBy($value)
 *
 * @mixin \Eloquent
 */
class Feed extends BaseModel
{
    /**
     * @var string[]
     */
    protected $fillable = ['id', 'created_at', 'updated_at'];
}
