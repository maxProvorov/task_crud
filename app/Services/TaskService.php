<?php

namespace App\Services;

use App\DTOs\TaskDTO;
use App\DTOs\UpdateTaskDTO;
use App\Models\Task;
use App\Repositories\TaskRepository;

class TaskService
{
    public function __construct(protected TaskRepository $repository)
    {}

    public function getAll()
    {
        return $this->repository->all();
    }

    public function createTask(TaskDto $dto): Task
    {
        return $this->repository->create($dto);
    }

    public function getTaskById(int $id): Task
    {
        return $this->repository->find($id);
    }

    public function updateTask(UpdateTaskDTO $dto, int $id): Task
    {
        return $this->repository->update($dto, $id);
    }

    public function destroyTaskById(int $id): bool
    {
        return $this->repository->destroy($id);
    }
}
