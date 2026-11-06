<?php

namespace App\DTO\Output;

class ExerciseOutputDTO {
    public int $id;
    public string $slug;
    public ?string $title;
    public ?string $description;
    public ?string $seoTitle;
    public ?string $seoDescription;
    public ?int $minExecutionMin;
    public ?int $maxExecutionMin;
    public ?string $difficulty;
    public ?array $spread;
}
