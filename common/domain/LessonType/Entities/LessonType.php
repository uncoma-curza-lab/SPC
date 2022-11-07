<?php

namespace common\domain\LessonType\Entities;

class LessonType
{
    public $description;
    public $max_use_percentage;

    public function __construct(string $description, $max_use_percentage = 100)
    {
        $this->description = $description;
        $this->max_use_percentage = $max_use_percentage;
    }

}

