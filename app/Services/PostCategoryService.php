<?php

namespace App\Services;

use App\Models\BlogCategory;
use App\Models\Post;
use App\Models\PostCategory;
use App\Repositories\PostCategoryRepository;
use App\Services\CrudService;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostCategoryService extends CrudService
{
    private PostCategory  $postCategory;
    private PostCategoryRepository $postCategoryRepository;

    public function __construct(
        PostCategoryRepository  $postCategoryRepository
    )
    {
        $this->postCategoryRepository = $postCategoryRepository;
    }

    public
    function getAll()
    {
        return $this->postCategoryRepository->all();
    }

    public function show(string $id)
    {
        $model = $this->postCategoryRepository->find($id);
        if (!$model) throw new NotFoundHttpException();
        return $model;
    }

    public
    function store(array $data)
    {
        DB::beginTransaction();

        try {
            $this->postCategory = $this->postCategoryRepository->create($data);
            DB::commit();
            return $this->postCategory;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    public
    function update(string $id, array $data)
    {
        DB::beginTransaction();
        try {
            $this->postCategory = $this->postCategoryRepository->update($id, $data);
            DB::commit();
            return $this->postCategory;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public
    function destroy(string $id)
    {
        /** @var Product $product */
        $tariff = $this->postCategoryRepository->find($id);
        if (!$tariff) throw new NotFoundHttpException();
        $this->postCategoryRepository->destroy($id);
        return [];
    }

}
