<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Models\Role;
use Modules\User\Models\User;
use Modules\Xot\Datas\XotData;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

// use Modules\Xot\Datas\XotData;

abstract class XotBasePolicy {
    use HandlesAuthorization;

    public function before(User $user, string $ability): bool|null {
        $xotData = XotData::make();
        if ($user->hasRole('super-admin')) {
            return true;
        }
        
        if ($user->email == $xotData->super_admin && null != $xotData->super_admin) {
            try {
                $user->assignRole('super-admin');
            } catch (RoleDoesNotExist) {
                $role = Role::firstOrCreate(['name' => 'super-admin', 'team_id' => null]);
                $user->assignRole($role);
            }

            return true;
        }

        return null;
    }
}
