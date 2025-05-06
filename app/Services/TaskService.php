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

    public function getAll(int $userId)
    {
        return $this->repository->all($userId);
    }

    public function createTask(TaskDto $dto, int $userId): Task
    {
        return $this->repository->create($dto, $userId);
    }

    public function getTaskById(int $id, int $userId): Task
    {
        return $this->repository->find($id, $userId);
    }

    public function updateTask(UpdateTaskDTO $dto, int $id, int $userId): Task
    {
        return $this->repository->update($dto, $id, $userId);
    }

    public function destroyTaskById(int $id, int $userId): bool
    {
        return $this->repository->destroy($id, $userId);
    }
}
