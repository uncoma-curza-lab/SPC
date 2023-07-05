<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

abstract class BaseModel extends ActiveRecord
{
    public static function find()
    {
        $class = get_class(Yii::$container->get(static::class));
        return Yii::createObject(ActiveQuery::class, [$class]);
    }
}
