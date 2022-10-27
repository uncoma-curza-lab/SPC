<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[LessonType]].
 *
 * @see LessonType
 */
class LessonTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return LessonType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return LessonType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
