<?php


namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }
    public function search($q)
    {
        return $this->model->where('name', 'Like', '%' . $q . '%')->paginate(12);
    }


    public function updateAvatar($request)
    {
        $model = $this->find($request['id']);
        $model->fill($request);
        $model->save();
        return $model;
    }



    public function changePassword($request)
    {
        $model = $this->find($request['id']);
        $request['password'] = bcrypt($request['password']);
        $model->fill($request);
        $model->save();
        return $model;
    }
}
