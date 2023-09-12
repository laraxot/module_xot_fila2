<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model\Update;

use Modules\Xot\DTOs\RelationDTO;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;

class HasManyDeepAction
{
    use QueueableAction;

    public function execute(Model $model, RelationDTO $relationDTO): void
    {
        dddx('wip');
    }
}
