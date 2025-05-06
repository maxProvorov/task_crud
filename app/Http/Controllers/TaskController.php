<?php

namespace App\Http\Controllers;

use App\DTOs\TaskDTO;
use App\DTOs\UpdateTaskDTO;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(protected TaskService $service)
    {}

    public function index(): JsonResponse
    {
        $userId = auth()->id();
        $userId = 1;
        return response()->json($this->service->getAll($userId), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:20',
            'text' => 'nullable|string|max:200',
            'tags' => 'array',
        ]);

        $dto = TaskDto::fromArray($validated);
        //$userId = auth()->id();
        $userId = 1;
        $task = $this->service->createTask($dto, $userId);
        return response()->json($task, 200);
    }

    public function show(int $id): JsonResponse
    {
        $userId = auth()->id();
        $userId = 1;
        return response()->json($this->service->getTaskById($id, $userId), 200);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|min:3|max:20',
            'text' => 'sometimes|nullable|string|max:200',
            'tags' => 'sometimes|array',
        ]);

        $dto = UpdateTaskDTO::fromArray($validated);
        $userId = auth()->id();
        $userId = 1;
        $task = $this->service->updateTask($dto, $id, $userId);
        return response()->json($task, 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $userId = auth()->id();
        $userId = 1;
        return response()->json($this->service->destroyTaskById($id, $userId), 200);
    }
}
