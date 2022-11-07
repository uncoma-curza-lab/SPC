<?php

namespace common\domain\LessonType\Entities;

class LessonType
{
    public $id;
    public $description;
    public $max_use_percentage;

    public function __construct(?int $id, string $description, $max_use_percentage = 100)
    {
        $this->id = $id;
        $this->description = $description;
        $this->max_use_percentage = $max_use_percentage;
    }

}

