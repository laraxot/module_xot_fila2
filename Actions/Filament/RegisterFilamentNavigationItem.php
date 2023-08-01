<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Filament;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Spatie\QueueableAction\QueueableAction;

class RegisterFilamentNavigationItem {
    use QueueableAction;

    /**
     * Undocumented function.
     */
    public static function execute($module, $context): void {
        $panel = \Str::of($context)->after('-')->replace('filament', 'default')->slug()->replace('-', ' ')->title()->title();
        $moduleContexts = app(GetModuleContexts::class)->execute($module);
        $module_lower = \Module::findOrFail($module)->getLowerName();
        // $can = static::hasAuthorizedAccess($context);
        $can = true;
        $navItem = NavigationItem::make($context)
            ->visible($can)
            ->url(route($context.'.pages.dashboard'))
            // ->icon('heroicon-o-bookmark')
            ->icon(config($module_lower.'.icon'))
            ->group('Modules');
        if ($can) {
            Filament::registerNavigationItems([
                1 === $moduleContexts->count() ? $navItem->label("$module") : $navItem->label("$panel Panel")->group("$module Module"),
            ]);
        }
    }
}
