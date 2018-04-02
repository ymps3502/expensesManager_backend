<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected $repository;

    public function __construct(TagREpository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeTag(Request $request)
    {
        $this->repository->createTag($request->all());
        return response()->json(['message' => 'add tag successfully'], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSubtag(Request $request)
    {
        $this->repository->createSubtag($request->all());
        return response()->json(['message' => 'add subtag successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \App\Tag
     */
    public function showAllTag()
    {
        $tags = $this->repository->allTag();
        return $tags;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function updateTag(Request $request, int $id)
    {
        $this->repository->updateTag($id, $request->all());
        return response()->json(['message' => 'update tag successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function updateSubtag(Request $request, int $id)
    {
        $this->repository->updateSubtag($id, $request->all());
        return response()->json(['message' => 'update subtag successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyTag(Request $request)
    {
        $this->repository->deleteTag($request->id);
        return response()->json(['message' => 'delete tag successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroySubtag(int $id)
    {
        $this->repository->deleteSubtag($id);
        return response()->json(['message' => 'delete subtag successfully'], 200);
    }
}
