<?php
namespace Modules\Xot\Models\Panels\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\LU\Models\User as User;
use Modules\Xot\Models\Panels\Policies\FailedJobPanelPolicy as Panel;

use Modules\Xot\Models\Panels\Policies\XotBasePanelPolicy;

class FailedJobPanelPolicy extends XotBasePanelPolicy {
}
