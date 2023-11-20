<?php

namespace App\Repositories;
use App\Models\PostCategory;
use App\Repositories\BaseRepository;

class PostCategoryRepository extends BaseRepository
{
    protected $model;
    const PAGINATE = 12;
    public $sortBy = 'updated_at';
    public $sortOrder = 'desc';

    public function __construct(PostCategory $model)
    {
        $this->model = $model;
    }
}
