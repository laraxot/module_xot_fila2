<?php

declare(strict_types=1);

namespace Modules\Xot\DTOs;

use Spatie\LaravelData\Data;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Relations\Relation;
//use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Undocumented class.
 */
class RelationDTO extends Data {
    public $rows;

    public array $data;

    public string $name;

    public string $relationship_type;

    public Model $related;
}