<?php

namespace App\Http\Controllers\API\Cabinet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cabinet\PostCategoryRequest;
use App\Http\Requests\Cabinet\PostRequest;
use App\Services\PostCategoryService;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostCategoryController extends Controller
{
    private PostCategoryService $service;

    public function __construct(PostCategoryService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $activities = $this->service->getAll();

        return response()->json($activities);
    }



    public function show($id)
    {
        return $this->service->show($id);
    }


    public function store(PostCategoryRequest $request)
    {
        return $this->service->store($request->all());
    }

    public function update(PostCategoryRequest  $request, $id)
    {
        return $this->service->update($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->service->destroy($id);
    }

}
