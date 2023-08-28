<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\XotBaseResource\RelationManager;

use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Support\Str;
use Webmozart\Assert\Assert;

abstract class XotBaseRelationManager extends RelationManager
{
    // protected static string $relationship = 'roles';

    // protected static ?string $recordTitleAttribute = 'name';

    public static function trans(string $key): string
    {
        $moduleNameLow = Str::lower(static::getModuleName());
        Assert::notNull(static::$model);
        $modelNameSlug = Str::kebab(class_basename(static::$model));
        $res = $moduleNameLow.'::'.$modelNameSlug.'.'.$key;
        $trans = __($res);

        return $trans;
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
