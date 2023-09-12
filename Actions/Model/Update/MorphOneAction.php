<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model\Update;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Xot\DTOs\RelationDTO;
use Spatie\QueueableAction\QueueableAction;

class MorphOneAction
{
    use QueueableAction;

    /**
     * Undocumented function.
     *
     * @return void
     */
    public function execute(Model $model, RelationDTO $relationDTO)
    {
        /* con update or create crea sempre uno nuovo, con update e basta se non esiste non va a crearlo */
        // $rows = $model->$name();
        if (! $relationDTO->rows instanceof MorphOne) {
            throw new \Exception('['.__LINE__.']['.__FILE__.']');
        }

        $rows = $relationDTO->rows;
        if ($rows->exists()) {
            $rows->update($relationDTO->data);
        } else {
            if (! isset($relationDTO->data['lang'])) {
                $relationDTO->data['lang'] = \App::getLocale();
            }

            $rows->create($relationDTO->data);
        }
    }
}
