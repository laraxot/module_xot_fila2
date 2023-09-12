<?php

declare(strict_types=1);

namespace Modules\Xot\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Xot\Models\Settings.
 *
 * @property int                             $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string                          $name
 * @property string|null                     $value
 *
 * @method static Builder|Settings newModelQuery()
 * @method static Builder|Settings newQuery()
 * @method static Builder|Settings query()
 * @method static Builder|Settings whereCreatedAt($value)
 * @method static Builder|Settings whereId($value)
 * @method static Builder|Settings whereName($value)
 * @method static Builder|Settings whereUpdatedAt($value)
 * @method static Builder|Settings whereValue($value)
 *
 * @mixin IdeHelperSettings
 * @mixin \Eloquent
 */
final class Settings extends Model
{
    /**
     * @var string[]
     */
    public $fillable = [
        'id', 'appname', 'description', 'keywords', 'author',
    ];
}
