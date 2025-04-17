<?php

declare(strict_types=1);

namespace Modules\Xot\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;
use Modules\User\Models\User;
use Spatie\ModelStatus\Status;

/**
 * Modules\Xot\Contracts\ModelWithStatusContract.
 *
 * <<<<<<< HEAD
 *
 * @property int                                                                   $id
 * @property int|null                                                              $user_id
 * @property string|null                                                           $post_type
 * @property Carbon|null                                                           $created_at
 * @property Carbon|null                                                           $updated_at
 * @property string|null                                                           $created_by
 * @property string|null                                                           $updated_by
 * @property string|null                                                           $title
 * @property PivotContract|null                                                    $pivot
 * @property string                                                                $tennant_name
 * @property User|null                                                             $user
 * @property string                                                                $status
 * @property Collection|array<Status>                                              $statuses
 * @property int|null                                                              $statuses_count
 *                                                                                                 =======
 * @property int                                                                   $id
 * @property int|null                                                              $user_id
 * @property string|null                                                           $post_type
 * @property \Illuminate\Support\Carbon|null                                       $created_at
 * @property \Illuminate\Support\Carbon|null                                       $updated_at
 * @property string|null                                                           $created_by
 * @property string|null                                                           $updated_by
 * @property string|null                                                           $title
 * @property PivotContract|null                                                    $pivot
 * @property string                                                                $tennant_name
 * @property \Modules\User\Models\User|null                                        $user
 * @property string                                                                $status
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\ModelStatus\Status[] $statuses
 * @property int|null                                                              $statuses_count
 *                                                                                                 >>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
 *
 * @method mixed     getKey()
 * @method string    getRouteKey()
 * @method string    getRouteKeyName()
 * @method string    getTable()
 * @method mixed     with($array)
 * @method array     getFillable()
 * @method mixed     fill($array)
 * @method mixed     getConnection()
 * @method mixed     update($params)
 * @method mixed     delete()
 * @method mixed     detach($params)
 * @method mixed     attach($params)
 * @method mixed     save($params)
 * @method array     treeLabel()
 * @method array     treeSons()
 * @method int       treeSonsCount()
 * @method mixed     bellBoys()
 * @method array     toArray()
 * @method BelongsTo user()
 *
 * @mixin \Eloquent
 */
interface ModelWithStatusContract
{
    public function statuses(): MorphMany;

    public function status(): ?Status;

    public function setStatus(string $name, ?string $reason = null): self;
}
