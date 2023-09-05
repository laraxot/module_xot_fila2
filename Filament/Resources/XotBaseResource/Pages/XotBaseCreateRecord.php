<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\XotBaseResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Savannabits\FilamentModules\Concerns\ContextualPage;

abstract class XotBaseCreateRecord extends CreateRecord
{
    use ContextualPage;
    protected static string $resource = XotBaseResource::class;
}
