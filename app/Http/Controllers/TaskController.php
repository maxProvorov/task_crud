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
        return response()->json($this->service->getAll(), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'status' => 'required',
        ]);

        $dto = TaskDto::fromArray($validated);
        $task = $this->service->createTask($dto);
        return response()->json($task, 200);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->service->getTaskById($id), 200);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|required|in:pending,completed',
        ]);

        $dto = UpdateTaskDTO::fromArray($validated);
        $task = $this->service->updateTask($dto, $id);
        return response()->json($task, 200);
    }

    public function destroy(int $id): JsonResponse
    {
        return response()->json($this->service->destroyTaskById($id), 200);
    }
}
