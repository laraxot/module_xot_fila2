<?php

declare(strict_types=1);

namespace Modules\Xot\Providers\Traits;

<<<<<<< HEAD
=======
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\URL;

>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
// use Modules\Xot\Engines\FullTextSearchEngine;

trait PanelTrait
{
    private function registerPanel(): void
    {
        // dddx(get_class_methods($this->app['request']));
        // dddx(get_class_methods($this->app['route']));
        // dddx(request()->route()->paremeters());
        // $request->route()->parameters()
        // {{ URL::toCurrentRouteWithParameters(['language' => 'az']) }}
        // dddx(optional(\Route::current())->parameters());
        // dddx(request()->route()->parameters());
        /*
        $this->app->singleton(
            PanelService::class,
            function (Container $app) {
                return new Panel(
                    $app['events'],
                    $app['route'],
                    $app
                );
            }
        );
        */
    }
}
