<?php

namespace common\domain\TimeDistribution\Entities;

use common\domain\LessonType\Entities\LessonType;
use common\models\Module;
use common\models\Programa;
use yii\base\Model;

class TimeDistribution extends Model
{
    public Programa $program;
    public LessonType $lessonType;
    public Module $module;

}
