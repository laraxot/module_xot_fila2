<?php

declare(strict_types=1);

namespace Modules\Xot\Http\Middleware;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Str;
<<<<<<< HEAD
use Nwidart\Modules\Laravel\Module;
=======
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
use Webmozart\Assert\Assert;

abstract class XotBaseFilamentMiddleware extends Middleware
{
    public static string $module = 'EWall';
<<<<<<< HEAD

=======
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    public static string $context = 'filament';

    protected function authenticate($request, array $guards): void
    {
<<<<<<< HEAD
        $contextName = $this->getContextName();
        Assert::string($guardName = config($contextName.'.auth.guard'), 'fix config ['.$contextName.'.auth.guard]');
=======
        $context = $this->getContextName();
        Assert::string($guardName = config("{$context}.auth.guard"), 'fix config ['.$context.'.auth.guard]');
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
        $guard = $this->auth->guard($guardName);

        if (! $guard->check()) {
            $this->unauthenticated($request, $guards);

            return;
        }

        $this->auth->shouldUse($guardName);

        $user = $guard->user();

        if ($user instanceof FilamentUser) {
            abort_if(! $user->canAccessFilament(), 403);

            return;
        }

        abort_if('local' !== config('app.env'), 403);
    }

    protected function redirectTo($request): string
    {
<<<<<<< HEAD
        $contextName = $this->getContextName();

        return route($contextName.'.auth.login');
    }

    /**
     * @return Module|\Nwidart\Modules\Module
=======
        $context = $this->getContextName();

        return route("{$context}.auth.login");
    }

    /**
     * @return \Nwidart\Modules\Laravel\Module|\Nwidart\Modules\Module
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
     */
    private function getModule()
    {
        return app('modules')->findOrFail(static::$module);
    }

    /**
     * @throws \Exception
     */
    private function getContextName(): string
    {
<<<<<<< HEAD
        $this->getModule();
        if ('' === static::$context || '0' === static::$context) {
=======
        $module = $this->getModule();
        if (! static::$context) {
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
            throw new \Exception('Context has to be defined in your class');
        }

        return Str::slug(static::$context);
        // dddx(Str::of($module->getLowerName())->append('-')->append(Str::slug(static::$context))->kebab()->toString());
        // return Str::of($module->getLowerName())->append('-')->append(Str::slug(static::$context))->kebab()->toString();
    }
}
