<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model;

use Session;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;

class DetachAction
{
    use QueueableAction;

    public function execute(Model $model, array $data, array $rules): Model
    {
        if (property_exists($model, 'pivot') && $model->pivot !== null) {
            return $model;
        }
        
        $res = $model->pivot->delete();
        if ($res) {
            Session::flash('status', 'scollegato');
        } else {
            Session::flash('status', 'NON scollegato');
        }

        return $model;
    }
}
