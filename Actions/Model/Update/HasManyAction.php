<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model\Update;

use Modules\Xot\DTOs\RelationDTO;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\QueueableAction\QueueableAction;

final class HasManyAction
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
            throw new Exception('['.__LINE__.']['.__FILE__.']');
        }

        if (isset($relationDTO->data['from']) && isset($relationDTO->data['to'])) {
            $f_key = $relationDTO->rows->getForeignKeyName();
            $res = $relationDTO->related->where($f_key, $model->getKey())
                ->update([$f_key => null]);
            foreach ($relationDTO->data['to'] as $item) {
                $row0 = $relationDTO->related
                    ->where('id', $item)
                    ->update([$f_key => $model->getKey()]);
            }

            return;
        }

        $rows = $relationDTO->rows;
        $rows->update($relationDTO->data);
    }
}
