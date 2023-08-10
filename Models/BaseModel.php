<?php

declare(strict_types=1);

namespace Modules\Xot\Models;

// use Laravel\Scout\Searchable;
// ---------- traits

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Services\FactoryService;
use Modules\Xot\Traits\Updater;

/**
 * Class BaseModel.
 */
abstract class BaseModel extends Model
{
    use HasFactory;
    // use Searchable;
    // //use Cachable;
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

    protected string $connection = 'mysql'; // this will use the specified database connection

    /**
     * @var array<string>
     */
    protected array $fillable = ['id'];
    /**
     * @var array<string, string>
     */
    protected array $casts = [
        // 'published_at' => 'datetime:Y-m-d', // da verificare
    ];

    /**
     * @var array<string>
     */
<<<<<<< HEAD
    protected $dates = ['published_at', 'created_at', 'updated_at'];
    /**
     * @var string
     */
    protected $primaryKey = 'id';

=======
    protected array $dates = ['published_at', 'created_at', 'updated_at'];
    protected string $primaryKey = 'id';
>>>>>>> b9465b74 (insights)
    /**
     * @var array<int, string>
     */
    protected array $hidden = [
        // 'password'
    ];

    /* -- spatie
    public function images():MorphMany {
        return $this->morphMany(Image::class, 'post');
    }
    */

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): \Illuminate\Database\Eloquent\Factories\Factory
    {
        return FactoryService::newFactory(static::class);
    }
}
