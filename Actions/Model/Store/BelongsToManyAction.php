<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model\Store;

use Modules\Xot\DTOs\RelationDTO;
use Session;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;

class BelongsToManyAction
{
    use QueueableAction;

    public function execute(Model $model, RelationDTO $relationDTO): void
    {
        /*
        dddx(['message' => 'wip',
            'row' => $row,
            'relation' => $relation, ]);
        */
        if (\in_array('to', array_keys($relationDTO->data), true) || \in_array('from', array_keys($relationDTO->data), true)) {
            // $this->saveMultiselectTwoSides($row, $relation->name, $relation->data);
            $to = $relationDTO->data['to'] ?? [];
            $model->{$relationDTO->name}()->sync($to);
            $status = 'collegati ['.implode(', ', $to).'] ';
            Session::flash('status', $status);

            return;
        }
        
        $model->{$relationDTO->name}()->sync($relationDTO->data);
    }
}
