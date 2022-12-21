<?php

declare(strict_types=1);

namespace Modules\Xot\DTOs;

use Illuminate\Database\Eloquent\Collection;
use Spatie\LaravelData\Data;

/**
 * Undocumented class.
 */
class RelationDTO extends Data {
    public Collection $rows;

    /**
     * @var int|string|array|null
     */
    public $data;

    public string $name;
}