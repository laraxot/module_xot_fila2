<?php

declare(strict_types=1);

namespace Modules\Xot\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modules\Xot\Contracts\ModelContract.
 *
 * <<<<<<< HEAD
 *
 * @property int         $id
 * @property int|null    $user_id
 * @property string|null $post_type
 * @property string|null $mail_subject
 * @property string|null                     mail_body
 * @property string|null                     theme
 * @property string|null                     sms_from
 * @property string|null                     mobile_phone
 * @property string|null                     sms_body
 * =======
 * @property int                             $id
 * @property int|null                        $user_id
 * @property string|null                     $post_type
 * @property string|null                     $mail_subject
 *                                                         >>>>>>> 0632fd0b (up)
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null                     $created_by
 * @property string|null                     $updated_by
 * @property string|null                     $title
 * @property bool                            $is_reclamed
 * @property bool                            $table_enable
 * @property PivotContract|null              $pivot
 * @property string                          $tennant_name
 * @property string                          $mail_subject
 * @property string                          $mail_body
 * @property string                          $sms_from
 * @property string                          $mobile_phone
 * @property string                          $sms_body
 * @property string                          $sms_count
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
 * @mixin  \Eloquent
 */
interface ModelContactContract
{
    public function getNotifyVia(): array;

    public function sendEmailCallback(): void;
}
