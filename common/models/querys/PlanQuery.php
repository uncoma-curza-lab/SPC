<?php

namespace common\models\querys;

class PlanQuery extends \yii\db\ActiveQuery
{

    public function all($db = null)
    {
        return parent::all($db);
    }

    public function one($db = null)
    {
        return parent::one($db);
    }

    public function onlyActive()
    {
        return $this->andWhere(['activo' => 1]);
    }

    public function onlyRootPlans()
    {
        return $this->andWhere(['is', 'parent_id', NULL]);
    }

}
