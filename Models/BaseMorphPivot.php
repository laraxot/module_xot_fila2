<?php

declare(strict_types=1);

namespace Modules\Xot\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Modules\Xot\Traits\Updater;

/**
 * Class BaseMorphPivot.
 */
abstract class BaseMorphPivot extends MorphPivot
{
    use Updater;
    /**
     * Indicates whether attributes are snake cased on arrays.
     *
     * @see https://laravel-news.com/6-eloquent-secrets
     */
    public static bool $snakeAttributes = true;

    public bool $incrementing = true;

    public bool $timestamps = true;

    /**
     * @var bool
     */
    public $incrementing = true;

    /**
     * @var bool
     */
    public $timestamps = true;

    protected $perPage = 30;

    protected $connection = 'mysql'; // this will use the specified database connection

    /**
     * @var array
     */
    protected array $appends = [];

<<<<<<< HEAD
    /**
     * @var string
     */
    protected $primaryKey = 'id';
=======
    protected string $primaryKey = 'id';
>>>>>>> b9465b74 (insights)

    // protected $attributes = ['related_type' => 'cuisine_cat'];
    /**
     * @var array<string>
     */
    protected array $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        // 'published_at',
    ];

    /**
     * @var array<string>
     */
    protected array $fillable = [
        'id',
        'post_id', 'post_type',
        'related_type',
        'user_id',
        'note',
    ];
}
