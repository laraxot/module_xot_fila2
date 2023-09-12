<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Arr;
use Modules\Xot\DTOs\RelationDTO;
use Spatie\LaravelData\DataCollection;
use Spatie\QueueableAction\QueueableAction;

class FilterRelationsAction
{
    use QueueableAction;

    /**
     * @return DataCollection<(int | string), RelationDTO>
     */
    public function execute(Model $model, array $data): DataCollection
    {
        $methods = get_class_methods($model);
        $res = collect($data)
            ->filter(
                static fn($value, $item): bool => \in_array($item, $methods, true)
            )
            ->filter(
                static function ($value, $item) use ($model) : bool {
                    $rows = $model->$item();
                    return $rows instanceof Relation;
                }
            )->map(
                static function ($value, $item) use ($model) : array {
                    $rows = $model->$item();
                    // $related = null;
                    // if (method_exists($rows, 'getRelated')) {
                    // Cannot call method getRelated() on class-string|object
                    $related = $rows->getRelated();

                    // }
                    // if(!is_array($value)){
                    //    dddx(['item'=>$item,'value'=>$value]);
                    // }
                    return [
                        'relationship_type' => class_basename($rows),
                        'related' => $related,
                        'name' => $item,
                        'rows' => $rows,
                        'data' => Arr::wrap($value),
                    ];
                })->all();

        return RelationDTO::collection($res);
    }
}
