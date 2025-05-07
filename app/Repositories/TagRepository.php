<?php

namespace App\Repositories;

use App\DTOs\TagDTO;
use App\Models\Tag;

class TagRepository
{
    public function all()
    {
        return Tag::all();
    }

    public function create(TagDto $dto): Tag
    {
        $tag = Tag::create($dto->toArray());

        return $tag;
    }

    public function find(int $id): Tag
    {
        return Tag::findOrFail($id);
    }

    public function update(TagDTO $dto, int $id): Tag
    {
        $tag = Tag::findOrFail($id);
        $tag->update($dto->toArray());

        return $tag;
    }

    public function destroy(int $id): bool
    {
        $tag = Tag::where('id', $id)->firstOrFail();
        return (bool) $tag->delete();
    }
}
