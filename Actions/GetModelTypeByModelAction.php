<?php
/**
 * @see https://github.com/protonemedia/laravel-ffmpeg
 */
declare(strict_types=1);

namespace Modules\Xot\Actions;

use Illuminate\Support\Str;
use Modules\Xot\Contracts\ModelContract;
use Spatie\QueueableAction\QueueableAction;

class GetModelTypeByModelAction
{
    use QueueableAction;

    /**
     * Execute the action.
     */
<<<<<<< HEAD
    public function execute(ModelContract $modelContract): string
=======
    public function execute(ModelContract $model): string
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        return Str::snake(class_basename($modelContract));
    }
}
