<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model\Update;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Xot\DTOs\RelationDTO;
use Spatie\QueueableAction\QueueableAction;

final class HasOneAction
{
    use QueueableAction;

    /**
     * Undocumented function.
     *
     * @return void
     */
    public function execute(Model $model, RelationDTO $relationDTO)
    {
        if (! $relationDTO->rows instanceof HasOne) {
            throw new Exception('['.__LINE__.']['.__FILE__.']');
        }
        
        $rows = $relationDTO->rows;
        // $rows= $row->{$relation->name}();
        if ($rows->exists()) {
            if (! \is_array($relationDTO->data)) {
                // variabile uguale alla relazione
            } else {
                // backtrace(true);
                // dddx([$model, $name, $data]);
                $model->{$relationDTO->name}->update($relationDTO->data);
            }
        } else {
            dddx(['err' => 'wip']);
            // $this->storeRelationshipsHasOne($params);
        }
    }
}
