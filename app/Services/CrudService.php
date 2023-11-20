<?php
namespace App\Services;

use App\Enums\AppErrorTypeEnum;
use App\Exceptions\AppException;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\BaseRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Illuminate\Database\Eloquent\Builder;

abstract class CrudService
{

    /**
     * @var BaseRepository
     */
    public $repository;

    /**
     * Метод для обертки логики в транзакцию
     *
     * @param callable $callback
     * @return mixed
     * @throws Throwable
     */
    public function transaction(Callable $callback)
    {
        $connection = $this->repository->getConnection();

        return $connection->transaction(function() use ($callback) {

            return call_user_func($callback);
        });
    }

    /**
     * Создание
     *
     * @param array $data
     * @return Builder|Model
     * @throws Throwable
     */
    public function create(array $data)
    {
        return $this->transaction(function () use( $data ) {
            $this->beforeCreate($data);
            $model = $this->repository->create($data);
            $this->afterCreate($model, $data);

            return $model;
        });
    }

    /**
     * Создание
     *
     * @param array $data
     * @return Builder|Model
     * @throws Throwable
     */
    public function updateById(int $id, array $data)
    {
        return $this->transaction(function () use( $id, $data ) {
            $this->beforeUpdate($data);
            $model = $this->repository->update($id, $data);
            $this->afterUpdate($model, $data);

            return $model;
        });
    }

    /**
     * @param $id
     * @param string|null $message
     * @return Model
     */
    public function oneByIdOrFail($id, string $message = null): Model
    {
        $model = $this->repository->find($id);
        if (!$model) {
            throw new NotFoundHttpException($message);
        }

        return $model;
    }

    public function beforeCreate(array &$data){}

    public function afterCreate(Model $model, array $data){}

    public function beforeUpdate(array &$data){}

    public function afterUpdate(Model $model, array $data){}
}
