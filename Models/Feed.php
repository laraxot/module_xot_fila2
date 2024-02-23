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
 * <<<<<<< HEAD
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
 * @method static Builder|Feed                                whereCreatedAt($value)
 * @method static Builder|Feed                                whereCreatedBy($value)
 * @method static Builder|Feed                                whereId($value)
 * @method static Builder|Feed                                whereUpdatedAt($value)
 * @method static Builder|Feed                                whereUpdatedBy($value)
 *                                                                                                =======
 * @method static \Modules\Xot\Database\Factories\FeedFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Feed  newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feed  newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feed  query()
 *
 * @mixin IdeHelperFeed
 *
 * @property int                             $id
 * @property string|null                     $created_by
 * @property string|null                     $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereUpdatedBy($value)
 *                                                                                  >>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
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
