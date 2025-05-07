<?php

namespace App\Services;

use App\DTOs\TagDTO;
use App\Models\Tag;
use App\Repositories\TagRepository;

class TagService
{
    public function __construct(protected TagRepository $repository)
    {}

    public function getAll()
    {
        return $this->repository->all();
    }

    public function createTag(TagDto $dto): Tag
    {
        return $this->repository->create($dto);
    }

    public function getTagById(int $id): Tag
    {
        return $this->repository->find($id);
    }

    public function updateTag(TagDTO $dto, int $id): Tag
    {
        return $this->repository->update($dto, $id);
    }

    public function destroyTagById(int $id): bool
    {
        return $this->repository->destroy($id);
    }
}
