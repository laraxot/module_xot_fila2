<?php

declare(strict_types=1);

namespace Modules\Xot\Providers;

use Savannabits\FilamentModules\ContextServiceProvider;
use Savannabits\FilamentModules\FilamentModules;

class XotBaseContextServiceProvider extends ContextServiceProvider {
    public static string $name = 'xot-filament';
    public static string $module = 'Xot';

    public function packageRegistered(): void {
        $this->app->booting(function () {
            $this->registerConfigs();
        });
        parent::packageRegistered();
    }

    public function registerConfigs() {
        $this->mergeConfigFrom(
            app('modules')->findOrFail(static::$module)->getExtraPath('Config/'.static::$name.'.php'),
            static::$name
        );
    }

    public function boot() {
        parent::boot();
        app(FilamentModules::class)->prepareDefaultNavigation(static::$module, static::$name);
    }
}
