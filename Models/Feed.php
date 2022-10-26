<?php

declare(strict_types=1);

namespace Modules\Xot\Models;

// --- services

// --- TRAITS ---

/**
 * Modules\Xot\Models\Feed.
 *
<<<<<<< HEAD
 * @property int                                                                  $post_id
=======
 * @property int                                                                  $id
 * @property string|null                                                          $created_by
 * @property string|null                                                          $updated_by
>>>>>>> d34c029 (up)
 * @property \Illuminate\Support\Carbon|null                                      $created_at
 * @property \Illuminate\Support\Carbon|null                                      $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|\Modules\Xot\Models\Image[] $images
 * @property int|null                                                             $images_count
 *
 * @method static \Modules\Xot\Database\Factories\FeedFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed  newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feed  newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feed  query()
 * @method static \Illuminate\Database\Eloquent\Builder|Feed  whereCreatedAt($value)
<<<<<<< HEAD
 * @method static \Illuminate\Database\Eloquent\Builder|Feed  wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed  whereUpdatedAt($value)
=======
 * @method static \Illuminate\Database\Eloquent\Builder|Feed  whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed  whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed  whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed  whereUpdatedBy($value)
>>>>>>> d34c029 (up)
 *
 * @mixin \Eloquent
 */
class Feed extends BaseModel {
    /**
     * @var string[]
     */
    protected $fillable = ['id', 'created_at', 'updated_at'];
}
