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
<<<<<<< HEAD

    public string $name = '';

=======
    public string $name = '';
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
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
<<<<<<< HEAD
            fn ($expression): string => '<'.sprintf('?php echo md_to_html(%s); ?', $expression).'>'
=======
            function ($expression) {
                return '<'."?php echo md_to_html({$expression}); ?".'>';
            }
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
        );

        Blade::directive(
            'formGroup',
<<<<<<< HEAD
            fn ($expression): string => '<div class="form-group<'.sprintf('?php echo $errors->has(%s) ? \' has-error\' : \'\' ?', $expression).'>">'
=======
            function ($expression) {
                return '<div class="form-group<'."?php echo \$errors->has({$expression}) ? ' has-error' : '' ?".'>">';
            }
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
        );

        Blade::directive(
            'endFormGroup',
            fn ($expression): string => '</div>'
        );

        Blade::directive(
            'title',
<<<<<<< HEAD
            fn ($expression): string => '<'.sprintf('?php $title = %s ?', $expression).'>'
=======
            function ($expression) {
                return '<'."?php \$title = {$expression} ?".'>';
            }
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
        );

        Blade::directive(
            'shareImage',
<<<<<<< HEAD
            fn ($expression): string => '<'.sprintf('?php $shareImage = %s ?', $expression).'>'
=======
            function ($expression) {
                return '<'."?php \$shareImage = {$expression} ?".'>';
            }
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
        );

        Blade::directive(
            'canonical',
<<<<<<< HEAD
            fn ($expression): string => '<'.sprintf('?php $canonical = %s ?', $expression).'>'
=======
            function ($expression) {
                return '<'."?php \$canonical = {$expression} ?".'>';
            }
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
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
