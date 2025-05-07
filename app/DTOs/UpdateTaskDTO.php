<?php

namespace App\DTOs;

class UpdateTaskDTO
{
    public function __construct(
        public ?string $title = null,
        public ?string $text = null,
        public ?array $tags = null,
    )
    {}

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'] ?? null,
            text: $data['text'] ?? null,
            tags: $data['tags'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'title' => $this->title,
            'text' => $this->text,
            'tags' => $this->tags,
        ], fn ($value) => !is_null($value));
    }
}
