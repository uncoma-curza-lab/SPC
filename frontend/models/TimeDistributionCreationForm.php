<?php

namespace frontend\models;

use common\domain\LessonType\Entities\LessonType;
use common\models\Module;
use common\models\Programa;
use Yii;
use yii\base\Model;

class TimeDistributionCreationForm extends Model
{
    public Programa $program;
    public $lesson_types;
    public Module $module;


    /**
     * {@inheritdoc}
     */
    //public function rules()
    //{
    //    return [
    //        // name, email, subject and body are required
    //        [['name', 'email', 'subject', 'body'], 'required'],
    //        // email has to be a valid email address
    //        ['email', 'email'],
    //        // verifyCode needs to be entered correctly
    //        ['verifyCode', 'captcha'],
    //    ];
    //}

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

}
