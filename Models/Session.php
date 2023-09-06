<?php

declare(strict_types=1);

namespace Modules\Xot\Models;

use Modules\Xot\Database\Factories\SessionFactory;
use Illuminate\Database\Eloquent\Builder;
/**
 * Modules\Xot\Models\Session.
 *
 * @property int         $id
 * @property int|null    $user_id
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string      $payload
 * @property int         $last_activity
 *
 * @method static SessionFactory factory($count = null, $state = [])
 * @method static Builder|Session newModelQuery()
 * @method static Builder|Session newQuery()
 * @method static Builder|Session query()
 * @method static Builder|Session whereId($value)
 * @method static Builder|Session whereIpAddress($value)
 * @method static Builder|Session whereLastActivity($value)
 * @method static Builder|Session wherePayload($value)
 * @method static Builder|Session whereUserAgent($value)
 * @method static Builder|Session whereUserId($value)
 *
 * @mixin IdeHelperSession
 * @mixin \Eloquent
 */
class Session extends BaseModel
{
    protected $fillable = ['id', 'user_id', 'ip_address', 'user_agent', 'payload', 'last_activity'];
}
