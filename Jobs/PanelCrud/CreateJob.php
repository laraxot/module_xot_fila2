<<<<<<< HEAD
<?php

declare(strict_types=1);

namespace Modules\Xot\Jobs\PanelCrud;

use Modules\Xot\Contracts\PanelContract;

//----------- Requests ----------
//------------ services ----------

/**
 * Class CreateJob.
 */
class CreateJob extends XotBaseJob {
    public function handle(): PanelContract {
        return $this->panel;
    }
}
=======
<?php

declare(strict_types=1);

namespace Modules\Xot\Jobs\PanelCrud;

use Modules\Xot\Contracts\PanelContract;

//----------- Requests ----------
//------------ services ----------

/**
 * Class CreateJob.
 */
class CreateJob extends XotBaseJob {
    public function handle(): PanelContract {
        return $this->panel;
    }
}
>>>>>>> 3c97c308c85924a62f31c89c71edfe23450749f0
