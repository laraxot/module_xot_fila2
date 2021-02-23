<<<<<<< HEAD
<?php

declare(strict_types=1);

namespace Modules\Xot\Traits;

use Illuminate\Support\Str;
use Modules\Xot\Contracts\PanelContract;

/**
 * Trait CrudContainerItemJobTrait.
 */
trait CrudContainerItemJobTrait {
    /**
     * @param string $name
     * @param array  $arg
     *
     * @return PanelContract
     */
    public function __call($name, $arg) {
        $func = '\Modules\Xot\Jobs\Crud\\'.Str::studly($name).'Job';
        $panel = $func::dispatchNow($arg[1], $arg[2]);

        return $panel;
    }
}
=======
<?php

declare(strict_types=1);

namespace Modules\Xot\Traits;

use Illuminate\Support\Str;
use Modules\Xot\Contracts\PanelContract;

/**
 * Trait CrudContainerItemJobTrait.
 */
trait CrudContainerItemJobTrait {
    /**
     * @param string $name
     * @param array  $arg
     *
     * @return PanelContract
     */
    public function __call($name, $arg) {
        $func = '\Modules\Xot\Jobs\Crud\\'.Str::studly($name).'Job';
        $panel = $func::dispatchNow($arg[1], $arg[2]);

        return $panel;
    }
}
>>>>>>> 3c97c308c85924a62f31c89c71edfe23450749f0
