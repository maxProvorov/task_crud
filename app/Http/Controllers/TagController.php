<?php

namespace App\Http\Controllers;

use App\DTOs\TagDTO;
use App\Services\TagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function __construct(protected TagService $service)
    {}

    public function index(): JsonResponse
    {
        return response()->json($this->service->getAll(), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:20',
        ]);

        $dto = TagDto::fromArray($validated);
        $tag = $this->service->createTag($dto);
        return response()->json($tag, 200);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->service->getTagById($id), 200);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:20',
        ]);

        $dto = TagDTO::fromArray($validated);
        $tag = $this->service->updateTag($dto, $id);
        return response()->json($tag, 200);
    }

    public function destroy(int $id): JsonResponse
    {
        return response()->json($this->service->destroyTagById($id), 200);
    }
}
