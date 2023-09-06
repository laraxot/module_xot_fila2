<?php

declare(strict_types=1);

namespace Modules\Xot\Providers;

use Illuminate\Support\Facades\Blade;
use Modules\Xot\Services\BladeService;
use Modules\Xot\Services\LivewireService;

/**
 * Class XotBaseThemeServiceProvider.
 *
 * @property string $dir
 * @property string $name
 */
abstract class XotBaseThemeServiceProvider
{
    public string $dir = '';
    public string $name = '';
    public string $ns = '';

    public function bootCallback(): void
    {
        /*
        $blade_component_path = '\Themes\LaravelIo\View\Components';
        foreach ($this->blade_components as $name => $class) {
            Blade::component($name, $blade_component_path.'\\'.$class);
        }
        */
        $this->registerBladeDirective();
        $this->registerBladeComponents();
        $this->registerLivewireComponents();
    }

    /**
     * Undocumented function.
     */
    public function registerBladeDirective(): void
    {
        Blade::directive(
            'md',
            fn($expression): string => '<'."?php echo md_to_html({$expression}); ?".'>'
        );

        Blade::directive(
            'formGroup',
            fn($expression): string => '<div class="form-group<'."?php echo \$errors->has({$expression}) ? ' has-error' : '' ?".'>">'
        );

        Blade::directive(
            'endFormGroup',
            fn($expression): string => '</div>'
        );

        Blade::directive(
            'title',
            fn($expression): string => '<'."?php \$title = {$expression} ?".'>'
        );

        Blade::directive(
            'shareImage',
            fn($expression): string => '<'."?php \$shareImage = {$expression} ?".'>'
        );

        Blade::directive(
            'canonical',
            fn($expression): string => '<'."?php \$canonical = {$expression} ?".'>'
        );
    }

    public function registerBladeComponents(): void
    {
        BladeService::registerComponents($this->dir.'/../View/Components', 'Themes\\'.$this->name);
    }

    public function registerLivewireComponents(): void
    {
        LivewireService::registerComponents($this->dir.'/../Http/Livewire', 'Themes\\'.$this->name);
    }
}
