<?php

namespace App\Services\User;

use App\Models\User;
use App\Models\UserWallet;
use App\Repositories\User\PermissionRepository;
use App\Repositories\User\RoleRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserService
{
    private $userRepository;
    private $roleRepository;
    private $permissionRepository;

    public function __construct(
        UserRepository       $userRepository,
        RoleRepository       $roleRepository,
        PermissionRepository $permissionRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    public
    function statusToogle($id, $status)
    {
        $model = $this->userRepository->find($id);
        $model->status = $status;
        $model->save();
        return $model;
    }

    public
    function detachPermission($id, $permission_id)
    {
        $user = config('roles.models.defaultUser')::find($id);
        $permission = config('roles.models.permission')::where('id', '=', $permission_id)->first();
        $user->detachPermission($permission);
        return $user;
    }

    public
    function attachPermission($id, $permission_id)
    {
        $user = config('roles.models.defaultUser')::find($id);
        $permission = config('roles.models.permission')::where('id', '=', $permission_id)->first();
        $user->attachPermission($permission);
        return $user;
    }


    public
    function uploadAvatar($id, UploadedFile $image)
    {
        $image = $image->store('users');
        $data = [
            'id' => $id,
            'avatar' => $image
        ];
        $model = $this->userRepository->updateAvatar($data);
        return [
            'id' => $model->id,
            'avatar' => $model->avatar,
        ];
    }


    public
    function detachRole($id, $role_id)
    {
        $user = config('roles.models.defaultUser')::find($id);
        $role = config('roles.models.role')::where('id', '=', $role_id)->first();
        $user->detachRole($role);
        return $user;
    }

    public
    function attachRole($id, $role_id)
    {
        $user = config('roles.models.defaultUser')::find($id);
        $role = config('roles.models.role')::where('id', '=', $role_id)->first();
        $user->attachRole($role);
        return $user;
    }

    /**
     * @param int $id
     * @param string|null $message
     * @return Model
     */
    public
    function oneByIdOrFail(int $id, string $message = null): Model
    {
        $model = $this->userRepository->find($id);
        if (!$model) {
            throw new NotFoundHttpException($message);
        }

        return $model;
    }

    public
    function getUser($data)
    {
        $user = User::where('email', $data['email'])->first();
        if (!isset($user)) {
            $user_ar = [
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => bcrypt(random_bytes(6)),
            ];
            $user = $this->userRepository->create($user_ar);
            $user_wallet = new UserWallet();
            $user_wallet->user_id = $user->id;
            $user_wallet->status = 1;
            $user_wallet->money = 1000;
            $user_wallet->save();
        }
        return $user;
    }


}
