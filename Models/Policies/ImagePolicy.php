<<<<<<< HEAD
<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Policies;

use Modules\Xot\Contracts\ModelContract;
use Modules\Xot\Contracts\UserContract;

/**
 * Class ImagePolicy.
 */
class ImagePolicy extends XotBasePolicy {
    public function store(UserContract $user, ModelContract $post): bool {
        return true; //da aggiungere pezzi
    }
}
=======
<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Policies;

use Modules\Xot\Contracts\ModelContract;
use Modules\Xot\Contracts\UserContract;

/**
 * Class ImagePolicy.
 */
class ImagePolicy extends XotBasePolicy {
    public function store(UserContract $user, ModelContract $post): bool {
        return true; //da aggiungere pezzi
    }
}
>>>>>>> 3c97c308c85924a62f31c89c71edfe23450749f0
