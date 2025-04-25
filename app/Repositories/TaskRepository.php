<?php

namespace App\Repositories;

use App\DTOs\TaskDTO;
use App\DTOs\UpdateTaskDTO;
use App\Models\Task;

class TaskRepository
{
    public function all()
    {
        return Task::all();
    }

    public function create(TaskDto $dto): Task
    {
        return Task::create($dto->toArray());
    }

    public function find(int $id): Task
    {
        return Task::findOrFail($id);
    }

    public function update(UpdateTaskDTO $dto, int $id): Task
    {
        $task = Task::findOrFail($id);
        $task->update($dto->toArray());

        return $task;
    }

    public function destroy(int $id): bool
    {
        return Task::destroy($id);
    }
}
