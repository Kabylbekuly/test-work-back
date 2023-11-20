<?php


namespace App\Repositories\User;

use App\Models\Role;
use App\Repositories\BaseRepository;

class RoleRepository extends BaseRepository
{
    protected $model;
    public function __construct(Role $model)
    {
        $this->model = $model;
    }
}
