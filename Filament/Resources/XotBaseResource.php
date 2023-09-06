<?php
/**
 * ---.
 */
declare(strict_types=1);

namespace Modules\Xot\Filament\Resources;

use Filament\Resources\Resource;
use Illuminate\Support\Str;
use Savannabits\FilamentModules\Concerns\ContextualResource;
use Webmozart\Assert\Assert;

abstract class XotBaseResource extends Resource
{
    use ContextualResource;

    protected static ?string $model = null;
    // protected static ?string $navigationIcon = 'heroicon-o-bell';
    // protected static ?string $navigationLabel = 'Custom Navigation Label';
    // protected static ?string $activeNavigationIcon = 'heroicon-s-document-text';
    // protected static bool $shouldRegisterNavigation = false;
    // protected static ?string $navigationGroup = 'Parametri di Sistema';
    protected static ?int $navigationSort = 3;

    public static function trans(string $key): string
    {
        $moduleNameLow = Str::lower(static::getModuleName());
        Assert::notNull(static::$model);
        $modelNameSlug = Str::kebab(class_basename(static::$model));
        $res = $moduleNameLow.'::'.$modelNameSlug.'.'.$key;

        return __($res);
    }

    public static function getModel(): string
    {
        // if (null != static::$model) {
        //    return static::$model;
        // }
        $moduleName = static::getModuleName()->toString();
        $modelName = Str::before(class_basename(static::class), 'Resource');
        $res = 'Modules\\'.$moduleName.'\Models\\'.$modelName;
        static::$model = $res;

        return $res;
    }

    public static function getPluralModelLabel(): string
    {
        return static::trans('navigation.plural');
    }

    public static function getNavigationLabel(): string
    {
        return static::trans('navigation.name');
        // return static::trans('navigation.plural');
    }

    public static function getNavigationGroup(): string
    {
        return static::trans('navigation.group.name');
    }
}
