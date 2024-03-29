<?php

declare(strict_types=1);

namespace Modules\Xot\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Modules\User\Models\User;

/**
 * Modules\Xot\Contracts\ModelWithAuthorContract.
 *
 * <<<<<<< HEAD
 *
 * @property int                             $id
 * @property int|null                        $user_id
 * @property string|null                     $post_type
 * @property Carbon|null                     $created_at
 * @property Carbon|null                     $updated_at
 * @property string|null                     $created_by
 * @property string|null                     $updated_by
 * @property string|null                     $title
 * @property PivotContract|null              $pivot
 * @property string                          $tennant_name
 * @property int|null                        $author_id
 * @property User|null                       $user
 * @property User|null                       $author
 *                                                         =======
 * @property int                             $id
 * @property int|null                        $user_id
 * @property string|null                     $post_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null                     $created_by
 * @property string|null                     $updated_by
 * @property string|null                     $title
 * @property PivotContract|null              $pivot
 * @property string                          $tennant_name
 * @property int|null                        $author_id
 * @property \Modules\User\Models\User|null  $user
 * @property \Modules\User\Models\User|null  $author
 *                                                         >>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
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
interface ModelWithAuthorContract
{
}
