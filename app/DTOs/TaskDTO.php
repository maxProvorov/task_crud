<?php

namespace App\DTOs;

class TaskDTO
{
    public function __construct(
        private string $title,
        private ?string $description = null,
        private string $status = 'pending',
    )
    {}

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            description: $data['description'] ?? null,
            status: $data['status'] ?? 'pending',
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
        ];
    }
}
