<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lesson_types".
 *
 * @property int $id
 * @property int $description
 *
 * @property TimeDistribution[] $timeDistributions
 */
class LessonType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lesson_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'required'],
            [['description'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTimeDistributions()
    {
        return $this->hasMany(TimeDistribution::className(), ['lesson_type_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return LessonTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LessonTypeQuery(get_called_class());
    }
}
