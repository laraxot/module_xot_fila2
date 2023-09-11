<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model\Update;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Actions\Model\FilterRelationsAction;
use Spatie\QueueableAction\QueueableAction;

class RelationAction
{
    use QueueableAction;

    /**
     * Undocumented function.
     */
    public function execute(Model $model, array $data): void
    {
        $relations = app(FilterRelationsAction::class)->execute($model, $data);
        /*
        if ('CompanyService' != class_basename($row)) {
            dddx([
                'basename' => class_basename($row),
                'row' => $row,
                'data' => $data,
                'relations' => $relations,
            ]);
        }
        */
        foreach ($relations as $relation) {
            $act = __NAMESPACE__.'\\'.$relation->relationship_type.'Action';
            app($act)->execute($model, $relation);
        }
    }
}
