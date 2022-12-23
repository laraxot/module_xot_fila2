<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model\Store;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\DTOs\RelationDTO;
use Spatie\QueueableAction\QueueableAction;

class MorphOneAction {
    use QueueableAction;

    public function __construct() {
    }

    public function execute(Model $row, RelationDTO $relation): void {
        //if (is_string($relation->data) && isJson($relation->data)) {
        //    $relation->data = json_decode($relation->data, true);
        //}
        $rows = $relation->rows;
        if ($rows->exists()) {
            // dddx('SI');
            $rows->update($relation->data);
        } else {
            // dddx($relation->data);
            $rows->create($relation->data);
        }
    }
}