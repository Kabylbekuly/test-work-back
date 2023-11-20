<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\PostRepository;
use App\Services\CrudService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostService extends CrudService
{
    private Post $post;
    private PostRepository $postRepository;

    public function __construct(
        PostRepository       $postRepository
    )
    {
        $this->postRepository = $postRepository;
    }

    public
    function getAll()
    {
        return $this->postRepository->with('category')->get();
    }

    public function show(string $id)
    {
        $model = $this->postRepository->find($id);
        if (!$model) throw new NotFoundHttpException();
        return $model;
    }

    public
    function store(array $data)
    {
        DB::beginTransaction();

        try {
            $this->post = $this->postRepository->create($data);
            DB::commit();
            return $this->post;
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

            $this->post = $this->postRepository->update($id, $data);
            DB::commit();
            return $this->post;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public
    function destroy(string $id)
    {
        /** @var Product $product */
        $model = $this->postRepository->find($id);
        if (!$model) throw new NotFoundHttpException();
        $this->postRepository->destroy($id);
        return [];
    }

}
