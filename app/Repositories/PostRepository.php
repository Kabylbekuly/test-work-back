<?php

namespace App\Repositories;
use App\Models\Post;
use App\Repositories\BaseRepository;

class PostRepository extends BaseRepository
{
    protected $model;
    const PAGINATE = 12;
    public $sortBy = 'updated_at';
    public $sortOrder = 'desc';

    public function __construct(Post $model)
    {
        $this->model = $model;
    }
}
