<?php

namespace App\Repositories;

use App\Bill;
use App\Tag;
use App\Subtag;

class TagRepository
{
    public function createTag(array $attributes)
    {
        return Tag::create($attributes);
    }

    public function createSubtag(array $attributes)
    {
        return Subtag::create($attributes);
    }

    public function updateTag(int $id, array $attributes)
    {
        return Tag::find($id)->update($attributes);
    }

    public function updateSubtag(int $id, array $attributes)
    {
        return Subtag::find($id)->update($attributes);
    }

    public function deleteTag(array $id)
    {
        return Tag::whereIn('id', $id)->delete();
    }

    public function deleteSubtag(int $id)
    {
        return Subtag::find($id)->delete();
    }

    public function allTag()
    {
        return Tag::select('id', 'name')
            ->with(['subtag' => function ($query) { $query->select('id', 'name', 'tag_id'); }])
            ->get();
    }
}