<?php

namespace common\domain\programs\commands\GetAllByCourse;

use common\models\Asignatura as Course;
use common\shared\commands\CommandInterface;

class GetAllByCourseProcess implements CommandInterface
{
    private Course $course;

    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    public function handle() : GetAllByCourseResult
    {
        try {
            $programs = $this->course->getProgramas()->all();
            $childs = $this->getChildPrograms($this->course->getChildrens()->with('programa')->all());
            $parents = $this->getParentPrograms($this->course->getParent()->with('programa')->one());

            return new GetAllByCourseResult(true, 'Success', ['programs' => array_merge($programs, $childs, $parents)]);

            
        } catch (\Throwable $e) {
            return new GetAllByCourseResult(false, 'error', []);
        }

    }

    protected function getParentPrograms($parent)
    {
        if ($parent == null) {
            return [];
        }

        $programs = $parent->getProgramas()->all();
        $parent = $parent->getParent()->with('programa')->one();
        if ($parent) {
            $programs = array_merge($this->getParentPrograms($parent), $programs);
        }

        return $programs;
    }

    protected function getChildPrograms(array $childs)
    {
        if (count($childs) == 0) {
            return [];
        }

        $programs = [];
        foreach ($childs as $child) {
            $programs = array_merge($child->getProgramas()->all(), $programs);
            $coursesChild = $child->getChildrens()->with('programas')->all();
            if (count($coursesChild) > 0) {
                $programs = array_merge($this->getChildPrograms($coursesChild), $programs);
            }
        }

        return $programs;
    }
}
