<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Filament;

use Filament\Facades\Filament;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

class GetModuleContexts
{
    use QueueableAction;

    /**
     * Undocumented function.
     */
    public function execute(string $module): Collection
    {
        $prefix = Str::of($module)->lower()->append('-')->toString();

        return collect(Filament::getContexts())
            ->keys()
<<<<<<< HEAD
            ->filter(fn ($item) => Str::of($item)->contains($prefix));
=======
            ->filter(fn ($item) => Str::of($item)->contains("{$prefix}"));
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    }
}
