<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model\Store;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Arr;
use Modules\Xot\DTOs\RelationDTO;
use Spatie\QueueableAction\QueueableAction;

class HasOneAction
{
    use QueueableAction;

    public function execute(Model $model, RelationDTO $relationDTO): void
    {
        // dddx(['row' => $row, 'relation' => $relation]);
        if (! $relationDTO->rows instanceof HasOne) {
            throw new Exception('['.__LINE__.']['.__FILE__.']');
        }

        $rows = $relationDTO->rows;

        if (! Arr::isAssoc($relationDTO->data) && 1 == count($relationDTO->data)) {
            $related_id = $relationDTO->data[0];
            $related = $relationDTO->related->find($related_id);
            if (! $related instanceof Model) {
                throw new Exception('['.__LINE__.']['.__FILE__.']');
            }
            
            $rows->save($related);

            return;
        }
        
        /*
        $rows = $relation->rows;
        try {
            $related = $rows->create($relation->data);
        } catch (\Exception $e) {
            // "SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry '1' for key 'PRIMARY' (SQL: insert into `liveuser_users` (`first_name`, `last_name`, `email`, `auth_user_id`, `created_by`, `updated_by`, `updated_at`, `created_at`) values (gfdsfs, fdsfds, fds
            // dddx(['e' => $e->getMessage(), 'data' => $data]);
            $related = $rows->update($relation->data);
        }
        if (! $model->{$relation->name}->exists()) {// collegamento non riuscito
            $pk_local = $rows->getLocalKeyName();
            $pk_fore = $rows->getForeignKeyName();
            $data1 = [$pk_local => $related->$pk_fore];
            $model->update($data1);
        }
        */
    }
}
