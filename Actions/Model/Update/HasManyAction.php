<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model\Update;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Xot\DTOs\RelationDTO;
use Spatie\QueueableAction\QueueableAction;

class HasManyAction
{
    use QueueableAction;

    /**
     * Undocumented function.
     *
     * @return void
     */
    public function execute(Model $model, RelationDTO $relationDTO)
    {
        if (! $relationDTO->rows instanceof HasMany) {
            throw new \Exception('['.__LINE__.']['.__FILE__.']');
        }

<<<<<<< HEAD
        if (isset($relationDTO->data['from']) && isset($relationDTO->data['to'])) {
            $f_key = $relationDTO->rows->getForeignKeyName();
            $res = $relationDTO->related->where($f_key, $model->getKey())
                ->update([$f_key => null]);
            foreach ($relationDTO->data['to'] as $item) {
                $row0 = $relationDTO->related
                    ->where('id', $item)
                    ->update([$f_key => $model->getKey()]);
=======
        if (isset($relation->data['from']) && isset($relation->data['to'])) {
            $f_key = $relation->rows->getForeignKeyName();
            $res = $relation->related->where($f_key, $row->getKey())
                ->update([$f_key => null]);
            foreach ($relation->data['to'] as $item) {
                $row0 = $relation->related
                    ->where('id', $item)
                    ->update([$f_key => $row->getKey()]);
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
            }

            return;
        }

        $rows = $relationDTO->rows;
        $rows->update($relationDTO->data);
    }
}
