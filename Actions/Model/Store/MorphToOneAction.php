<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model\Store;

use Exception;
use App;
use Fidum\EloquentMorphToOne\MorphToOne;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\DTOs\RelationDTO;
use Spatie\QueueableAction\QueueableAction;

class MorphToOneAction
{
    use QueueableAction;

    public function execute(Model $model, RelationDTO $relationDTO): void
    {
        // dddx(['row' => $row, 'relation' => $relation, 'relation_data' => $relation->data]);
        if (! $relationDTO->rows instanceof MorphToOne) {
            throw new Exception('['.__LINE__.']['.__FILE__.']');
        }
        
        $rows = $relationDTO->rows;

        // if (is_array($relation->data)) {
        if (! isset($relationDTO->data['lang'])) {
            $relationDTO->data['lang'] = App::getLocale();
        }
        
        $rows->create($relationDTO->data);
        // } else {
        //    $rows->sync($relation->data);
        // }

        /*
        dddx([
            'message' => 'wip',
            'row' => $row,
            'relation' => $relation,
            'relation_rows' => $relation->rows->exists(),
            't' => $row->{$relation->name},
        ]);

        dddx('wip');
        */
    }
}
