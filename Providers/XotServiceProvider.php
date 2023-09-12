<?php

declare(strict_types=1);

namespace Modules\Xot\Providers;

use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Modules\Cms\Services\PanelService;
use Modules\Xot\Console\Commands\DatabaseBackUpCommand;
use Modules\Xot\Providers\Traits\TranslatorTrait;
use Modules\Xot\Services\ProfileTest;
use Modules\Xot\View\Composers\XotComposer;

/**
 * Class XotServiceProvider.
 */
class XotServiceProvider extends XotBaseServiceProvider
{
    // use Traits\PresenterTrait;
    use TranslatorTrait;

    public string $module_name = 'xot';

    /**
     * The module directory.
     */
    protected string $module_dir = __DIR__;

    /**
     * The module namespace.
     */
    protected string $module_ns = __NAMESPACE__;

    public function bootCallback(): void
    {
        $this->registerCommands();

        $this->redirectSSL();

        $this->registerTranslator();

        // $this->registerCacheOPCache();
        // $this->registerScout();

        // $this->registerLivewireComponents();

        $this->registerViewComposers(); // rompe filament

        // $this->registerPanel();
        // $this->registerDropbox();// PROBLEMA DI COMPOSER
        $this->registerEvents();
    }

    // end bootCallback

    public function registerCallback(): void
    {
        // $this->loadHelpersFrom(__DIR__.'/../Helpers'); //non serve piu
        $aliasLoader = AliasLoader::getInstance();
        $aliasLoader->alias('Panel', PanelService::class);

        // $loader->alias(\Modules\Xot\Facades\Profile::class,
        // $this->registerPresenter();

        // $this->registerPanel();
        // $this->registerBladeDirectives(); //non intercetta
        // $this->app->singleton('profile', function (Application $app) {
        //    return new \Modul
        // });
        // $this->app->bind('profile', \Modules\Xot\Services\ProfileTest::class);

        $this->app->bind(
            'profile',
            fn (): ProfileTest => new ProfileTest()
        );
    }

    /*
    public function mergeConfigs(): void {
        $configs = ['database', 'filesystems', 'auth', 'metatag', 'services', 'xra', 'social'];
        foreach ($configs as $v) {
            $tmp = Tenant::config($v);
            //dddx($tmp);
        }
        //DB::purge('mysql');//Call to a member function prepare() on null
        //DB::purge('liveuser_general');
        //DB::reconnect();
    }

    //end mergeConfigs
    //*/
    public function loadHelpersFrom(string $path): void
    {
        $files = File::files($path);
        foreach ($files as $file) {
            if ('php' !== $file->getExtension()) {
                continue;
            }
            if (false === $file->getRealPath()) {
                continue;
            }
            include_once $file->getRealPath();
        }
    }

    /*
    public function mergeConfigs(): void {
        $configs = ['database', 'filesystems', 'auth', 'metatag', 'services', 'xra', 'social'];
        foreach ($configs as $v) {
            $tmp = Tenant::config($v);
            //dddx($tmp);
        }
        //DB::purge('mysql');//Call to a member function prepare() on null
        //DB::purge('liveuser_general');
        //DB::reconnect();
    }

    //end mergeConfigs
    //*/

    private function redirectSSL(): void
    {
        // --- meglio ficcare un controllo anche sull'env
        if (config('xra.forcessl') && (isset($_SERVER['SERVER_NAME']) && 'localhost' !== $_SERVER['SERVER_NAME']
            && isset($_SERVER['REQUEST_SCHEME']) && 'http' === $_SERVER['REQUEST_SCHEME'])) {
            URL::forceScheme('https');
            /*
             * da fare in htaccess
             */
            if (! request()->secure() /* && in_array(env('APP_ENV'), ['stage', 'production']) */) {
                exit(redirect()->secure(request()->getRequestUri()));
            }
        }
    }

    /**
     * Undocumented function.
     *
     * @see https://medium.com/@dobron/running-laravel-ide-helper-generator-automatically-b909e75849d0
     */
    private function registerEvents(): void
    {
        Event::listen(
            MigrationsEnded::class,
            static function (): void {
                Artisan::call('ide-helper:models -r -W');
            }
        );
    }

    /**
     * Undocumented function.
     */
    private function registerCommands(): void
    {
        $this->commands(
            [
                // \Modules\Xot\Console\CreateAllRepositoriesCommand::class,
                // \Modules\Xot\Console\PanelMakeCommand::class,
                // \Modules\Xot\Console\FixProvidersCommand::class,
                DatabaseBackUpCommand::class,
                // \Modules\Xot\Console\Commands\WorkerCheck::class,
                // \Modules\Xot\Console\Commands\WorkerRetry::class,
                // \Modules\Xot\Console\Commands\WorkerStop::class,
            ]
        );
    }

    // Method Modules\Xot\Providers\XotServiceProvider::registerViewComposers() is unused
    private function registerViewComposers(): void
    {
        // Factory $view
        // $view->composer('bootstrap-italia::page', BootstrapItaliaComposer::class);
        View::composer('*', XotComposer::class);
        // dddx($res);
    }
} // end class
