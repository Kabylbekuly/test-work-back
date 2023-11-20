<?php


namespace App\Repositories\User;

use App\Models\Permission;
use App\Models\Role;
use App\Repositories\BaseRepository;

class PermissionRepository extends BaseRepository
{
    protected $model;

    public function __construct(Permission $model)
    {
        $this->model = $model;
    }
}
