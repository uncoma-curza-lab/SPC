<?php

namespace common\domain\programs\commands\GetAllByCourse;

use common\models\Asignatura as Course;
use common\models\Module;
use common\models\PermisosHelpers;
use common\models\Programa as Program;
use common\models\Status;
use common\shared\commands\CommandInterface;
use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;

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
            $childs = $this->getChildPrograms($this->course->getChildrens()->with('programas')->all());
            $parents = $this->getParentPrograms($this->course->getParent()->with('programas')->one());

            return new GetAllByCourseResult(true, 'Success', ['programs' => array_merge($programs, $childs, $parents)]);

            
        } catch (\Throwable $e) {
            return new GetAllByCourseResult(false, 'error', []);
        }

    }

    protected function getParentPrograms($parent)
    {
        $programs = $parent->getProgramas()->all();
        $parent = $parent->getParent()->with('programas')->one();
        if ($parent) {
            $programs = array_merge($this->getParentPrograms($parent), $programs);
        }

        return $programs;
    }

    protected function getChildPrograms(array $childs)
    {
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
