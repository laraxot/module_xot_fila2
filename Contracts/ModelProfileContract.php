<?php

declare(strict_types=1);

namespace Modules\Xot\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Modules\User\Models\Role;
use Spatie\Permission\Contracts\Permission;
use Illuminate\Database\Query\Builder;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;

/**
 * Modules\Xot\Contracts\ModelProfileContract.
 *
 * @property string                                                                   $id
 * @property string                                                                   $email
 * @property Collection<int, Role> $roles
 * @property int|null                                                                 $roles_count
 *
 * @mixin \Eloquent
 */
interface ModelProfileContract extends ModelContract
{
    /**
     * Grant the given permission(s) to a role.
     *
     * @param string|int|array|Permission|\Illuminate\Support\Collection $permissions
     *
     * @return $this
     */
    public function givePermissionTo(array $permissions = []);

    /**
     * Assign the given role to the model.
     *
     * @param array|string|int|\Spatie\Permission\Contracts\Role|\Illuminate\Support\Collection ...$roles
     *
     * @return $this
     */
    public function assignRole(array $roles = []);

    /**
     * Determine if the model has (one of) the given role(s).
     *
     * @param string|int|array|\Spatie\Permission\Contracts\Role|\Illuminate\Support\Collection $roles
     */
    public function hasRole($roles, string $guard = null): bool;

    /**
     * Determine if the model has any of the given role(s).
     *
     * Alias to hasRole() but without Guard controls
     *
     * @param string|int|array|\Spatie\Permission\Contracts\Role|\Illuminate\Support\Collection $roles
     */
    public function hasAnyRole(array $roles = []): bool;

    /**
     * Determine if the model may perform the given permission.
     *
     * @param string|int|Permission $permission
     * @param string|null                                        $guardName
     *
     * @throws PermissionDoesNotExist
     */
    public function hasPermissionTo($permission, $guardName = null): bool;

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query);
}
