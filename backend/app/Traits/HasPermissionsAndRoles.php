<?php
namespace App\Traits;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasPermissionsAndRoles {
    
    /**
     * The roles that belong to the user.
     */
    public function roles(): BelongsToMany
    {
        return $this->morphToMany(Role::class, 'model', 'model_has_roles');
    }

    /**
     * Get the name of the first assigned role as a dynamic attribute.
     * E.g., auth()->user()->role_nama
     *
     * @return string|null
     */
    public function getRoleNamaAttribute(): ?string
    {
        return $this->roles->first()?->nama;
    }

    /**
     * Get the full Role instance of the first assigned role as a dynamic attribute.
     * E.g., auth()->user()->primary_role->nama
     *
     * @return \App\Models\Role|null
     */
    public function getPrimaryRoleAttribute(): ?Role
    {
        return $this->roles->first();
    }

    /**
     * The permissions that belong to the user directly.
     */
    public function permissions(): BelongsToMany
    {
        return $this->morphToMany(Permission::class, 'model', 'model_has_permissions');
    }

    // ... (rest of your existing methods like hasRole, hasAnyRole, hasPermissionTo, assignRole, etc.)

    /**
     * Determine if the user has the given role.
     */
    public function hasRole(string $roleName): bool
    {
        return $this->roles->contains('nama', $roleName);
    }

    /**
     * Determine if the user has any of the given roles.
     */
    public function hasAnyRole(array $roleNames): bool
    {
        return $this->roles->pluck('nama')->intersect($roleNames)->isNotEmpty();
    }

    /**
     * Determine if the user has the given permission directly or via a role.
     */
    public function hasPermissionTo(string $permissionName): bool
    {
        // Check direct permissions
        if ($this->permissions->contains('nama', $permissionName)) {
            return true;
        }

        // Check permissions via roles
        return $this->roles->load('permissions')
                    ->pluck('permissions')
                    ->flatten()
                    ->contains('nama', $permissionName);
    }

    /**
     * Assign a role to the user.
     */
    public function assignRole(...$roles)
    {
        $roles = collect($roles)->flatten()->map(function ($role) {
            return $role instanceof Role ? $role->id : Role::where('nama', $role)->firstOrFail()->id;
        });

        $this->roles()->syncWithoutDetaching($roles);
    }

    /**
     * Revoke a role from the user.
     */
    public function removeRole(...$roles)
    {
        $roles = collect($roles)->flatten()->map(function ($role) {
            return $role instanceof Role ? $role->id : Role::where('nama', $role)->firstOrFail()->id;
        });

        $this->roles()->detach($roles);
    }

    /**
     * Give a direct permission to the user.
     */
    public function givePermissionTo(...$permissions)
    {
        $permissions = collect($permissions)->flatten()->map(function ($permission) {
            return $permission instanceof Permission ? $permission->id : Permission::where('nama',$permission)->firstOrFail()->id;
        });

        $this->permissions()->syncWithoutDetaching($permissions);
    }

    /**
     * Revoke a direct permission from the user.
     */
    public function revokePermissionTo(...$permissions)
    {
        $permissions = collect($permissions)->flatten()->map(function ($permission) {
            return $permission instanceof Permission ? $permission->id : Permission::where('nama',$permission)->firstOrFail()->id;
        });

        $this->permissions()->detach($permissions);
    }
}