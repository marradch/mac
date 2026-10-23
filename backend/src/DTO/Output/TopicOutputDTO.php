<?php

namespace App\DTO\Output;

class TopicOutputDTO
{
    public int $id;
    public string $slug;
    public ?string $title;
    public ?string $description;
    public ?string $seo_title;
    public ?string $seo_description;

    /** @var list<array{slug: string, text: string|null}>|null */
    public ?array $questions;
}
