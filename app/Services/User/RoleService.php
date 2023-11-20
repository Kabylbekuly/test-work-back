<?php

namespace App\Services\User;

use App\Repositories\User\PermissionRepository;
use App\Repositories\User\RoleRepository;
use Carbon\Carbon;

class RoleService
{
    private $roleRepository;
    private $permissionRepository;

    public function __construct(RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    public function deletePermission($id, $permission_id)
    {
        $role = config('roles.models.role')::where('id', '=', $id)->with('permissions')->first();
        $permission = config('roles.models.permission')::where('id', '=', $permission_id)->first();
        $role->detachPermission($permission); // in case you want to detach permission
        return $role;
    }

    public function attachPermission($id, $permission_id)
    {
        $role = config('roles.models.role')::where('id', '=', $id)->with('permissions')->first();
        $permission = config('roles.models.permission')::where('id', '=', $permission_id)->first();
        $role->attachPermission($permission); // in case you want to detach permission
        return $role;
    }


}
