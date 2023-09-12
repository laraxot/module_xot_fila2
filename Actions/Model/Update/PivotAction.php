<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model\Update;

use Modules\Xot\DTOs\RelationDTO;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;

final class PivotAction
{
    use QueueableAction;

    /**
     * Undocumented function.
     */
    public function execute(Model $model, RelationDTO $relationDTO): void
    {
        dddx('wip');
        /*

            $parent_panel = $this->panel->getParent();
            if (null !== $parent_panel) {
                $parent_row = $parent_panel->getRow();
                $panel_name = $this->panel->getName();
                $parent_row->{$panel_name}()->updateExistingPivot($model->getKey(), $data);
            }


        */
    }
}
