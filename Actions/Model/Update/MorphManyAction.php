<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model\Update;

use Modules\Xot\DTOs\RelationDTO;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;

class MorphManyAction
{
    use QueueableAction;

    /**
     * Undocumented function.
     */
    public function execute(Model $model, RelationDTO $relationDTO): void
    {
        dddx('wip');
    }
}
