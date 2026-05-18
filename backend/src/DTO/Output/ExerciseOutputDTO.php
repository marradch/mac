<?php

namespace App\DTO\Output;

class ExerciseOutputDTO {
    public int $id;
    public string $slug;
    public ?string $title;
    public ?string $description;
    public ?string $seo_title;
    public ?string $seo_description;
}
