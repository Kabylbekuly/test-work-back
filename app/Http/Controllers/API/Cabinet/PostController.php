<?php

namespace App\Http\Controllers\API\Cabinet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cabinet\PostRequest;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController  extends Controller
{
    private PostService $service;

    public function __construct(PostService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {

        return response()->json($this->service->getAll());
    }



    public function show($id)
    {
        return $this->service->show($id);
    }


    public function store(PostRequest $request)
    {
        return $this->service->store($request->all());
    }

    public function update(PostRequest $request, $id)
    {
        return $this->service->update($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->service->destroy($id);
    }





}

