<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model\Update;

use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;

class PivotAction {
    use QueueableAction;

    public function __construct() {
    }

    /**
     * Undocumented function
     *
     * @param Model $row
     * @param object $relation
     * @return void
     */
    public function execute(Model $row, object $relation) {
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
