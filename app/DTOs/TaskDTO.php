<?php

namespace App\DTOs;

class TaskDTO
{
    public function __construct(
        public string $title,
        public ?string $text = null,
        public ?array $tags = null,
    )
    {}

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            text: $data['text'] ?? null,
            tags: $data['tags'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'text' => $this->text,
            'tags' => $this->tags,
        ];
    }
}
