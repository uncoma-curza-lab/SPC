<?php

namespace common\domain\LessonType\commands\GetLessonTypes;

use common\domain\LessonType\Entities\LessonType;
use common\models\LessonType as LessonTypeDbModel;
use common\shared\commands\CommandInterface;

class GetLessonTypesCommand implements CommandInterface
{
    public function handle() : GetLessonTypesResult
    {
        try {
            $lessonTypesFromDB = LessonTypeDbModel::find()->all();
            $lessonTypes = array_map(function(LessonTypeDbModel $lessonType) {
                return new LessonType($lessonType->description, $lessonType->max_use_percentage);
            }, $lessonTypesFromDB);
            return new GetLessonTypesResult(true, 'Fueron eliminadas con éxito', [ 'data' => $lessonTypes ]);
        } catch (\Throwable $e) {
            return new GetLessonTypesResult(false, 'Hubo un error al eliminar alguna notification', ['exception' => $e]);
        }
    }
}
