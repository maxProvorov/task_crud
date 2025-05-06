<?php

namespace App\Repositories;

use App\DTOs\TaskDTO;
use App\DTOs\UpdateTaskDTO;
use App\Models\Task;

class TaskRepository
{
    public function all(int $userId)
    {
        return Task::with('tags')->where('user_id', $userId)->get();
    }

    public function create(TaskDto $dto, int $userId): Task
    {
        $task = Task::create(array_merge($dto->toArray(), ['user_id' => $userId]));

        if($dto->tags) {
            $task->tags()->sync($dto->tags);
        }

        return $task->load('tags');
    }

    public function find(int $id, int $userId): Task
    {
        return Task::with('tags')->where('user_id', $userId)->findOrFail($id);
    }

    public function update(UpdateTaskDTO $dto, int $id, int $userId): Task
    {
        $task = Task::findOrFail($id);
        $task->update(array_merge($dto->toArray(), ['user_id' => $userId]));

        return $task->load('tags');
    }

    public function destroy(int $id, int $userId): bool
    {
        $task = Task::where('id', $id)->where('user_id', $userId)->firstOrFail();
        return (bool) $task->delete();
    }
}
