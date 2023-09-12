<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model\Update;

use Exception;
use App;
use Fidum\EloquentMorphToOne\MorphToOne;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\DTOs\RelationDTO;
use Spatie\QueueableAction\QueueableAction;

final class MorphToOneAction
{
    use QueueableAction;

    /**
     * Undocumented function.
     *
     * @return void
     */
    public function execute(Model $model, RelationDTO $relationDTO)
    {
        // dddx(['row' => $row, 'relation' => $relation]);
        if (! $relationDTO->rows instanceof MorphToOne) {
            throw new Exception('['.__LINE__.']['.__FILE__.']');
        }
        
        $rows = $relationDTO->rows;

        // if (is_array($relation->data)) {
        if (! isset($relationDTO->data['lang'])) {
            $relationDTO->data['lang'] = App::getLocale();
        }
        
        $rows->create($relationDTO->data);
        // }
        // else {
        //    $rows->sync($relation->data);
        // }
    }
}
