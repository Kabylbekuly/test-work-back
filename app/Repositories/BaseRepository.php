<?php


namespace App\Repositories;

use Exception;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BaseRepository
{
    public $sortBy = 'created_at';
    public $sortOrder = 'asc';

    /**
     * @var Model
     */
    protected $model;

    /**
     * Возвращает модель
     *
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    public function getTable()
    {
        return $this->model->getTable();
    }

    /**
     * Возвращает подключение к БД
     *
     * @return Connection
     */
    public function getConnection()
    {
        return $this->model->getConnection();
    }

    /**
     * Get all elements on Model
     * @return mixed
     */
    public function all()
    {
        return $this->model
            ->orderBy($this->sortBy, $this->sortOrder)
            ->get();
    }

    /**
     * Get paginated elements on Model
     * @param $paginate
     * @return mixed
     */
    public function paginated($paginate = 30)
    {
        return $this
            ->model
            ->orderBy($this->sortBy, $this->sortOrder)
            ->paginate($paginate);
    }

    /**
     * Insert any element to Database
     * @param $input
     * @return mixed
     */
    public function create($input)
    {
        $model = new $this->model;
        $model->fill($input);
        $model->save();
        return $model;
    }

    /**
     * Find one element by id on Model
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->getModel()->find($id);
    }

    /**
     * Delete one element by id on Model
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->getModel()->where('id',$id)->delete();
    }

    /**
     * Update one element by id on Model
     * @param $id
     * @param array $input
     * @return mixed
     */
    public function update($id, array $input)
    {
        $model = $this->find($id);
        $model->fill($input);
        $model->save();

        return $model;
    }

    /**
     * Split full name
     * @param $name
     * @return array|bool
     */
    public function split_name($name)
    {
        $arr = explode(' ', $name);
        $num = count($arr);
        $s_name = $name = $p_name = null;

        if ($num == 2 && $num > 1) {
            list($s_name, $name) = $arr;
        } elseif ($num > 1) {
            list($s_name, $name, $p_name) = $arr;
        }

        return (empty($s_name) || $num > 3 || $num <= 1) ? false : compact(
            's_name',
            'name',
            'p_name'
        );
    }

    /**
     * Get filtered ordered paginated elements from Model
     * @param $request
     * @param $per_page
     * @param $order_by
     * @param $order
     * @return mixed
     */
    public function filteredOrderedPaginated($request, $per_page, $order_by, $order)
    {
        return $this->model->filter($request)->orderBy($order_by, $order)->paginate($per_page);
    }

    /**
     * Get filtered latest paginated elements from Model
     * @param $request
     * @param $per_page
     * @return mixed
     */
    public function filteredLatestPaginated($request, $per_page)
    {
        return $this->model->filter($request)->latest()->paginate($per_page);
    }

    /**
     * Get By Role Filtered Latest Paginated elements from model
     * @param $request
     * @param $per_page
     * @return mixed
     */
    public function getByRoleFilteredLatestPaginated($request, $per_page)
    {
        return $this->model->getByRole($request)->filter($request)->latest()->paginate($per_page);
    }

    /**
     * Get elements count by email on users table
     * @param $email
     * @param null $id
     * @return mixed
     */
    public function countByEmail($email, $id = null)
    {
        if ($id)
            return User::where('email', $email)->where('id', '<>', $id)->whereNull('deleted_at')->count();

        return User::where('email', $email)->whereNull('deleted_at')->count();
    }

    /**
     * Get array with id and name ['id' => 'name']
     * @return mixed
     */
    public function getArray()
    {
        return $this->model->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
    }
    public function with($relations)
    {
        return $this->model->with($relations);

    }
}
