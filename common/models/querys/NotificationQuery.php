<?php
namespace common\models\querys;
use common\models\NotificationPanel;
use common\models\NotificationEmail;
use yii\db\ActiveQuery;

class NotificationQuery extends ActiveQuery
{
    public $type;

    public function prepare($builder)
    {
        if ($this->type !== null) {
            $this->andWhere(['type' => $this->type]);
        }
        return parent::prepare($builder);
    }
    // conditions appended by default (can be skipped)
    public function init()
    {
        //$this->andOnCondition(['type' => self::DISCR]);
        parent::init();
    }

    // ... add customized query methods here ...

    public function panel()
    {
        return $this->andOnCondition(['type' => NotificationPanel::DISCR]);
    }
}