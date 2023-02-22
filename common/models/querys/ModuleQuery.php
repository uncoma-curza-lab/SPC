<?php

namespace common\models\querys;

use common\models\Module;

/**
 * This is the ActiveQuery class for [[Modules]].
 *
 * @see Moduel
 */
class ModuleQuery extends \yii\db\ActiveQuery
{

    /**
     * {@inheritdoc}
     * @return Contests[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Contests|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function oneByTimeDistributionTypeAndProgram(int $program_id)
    {
        return $this->where(['program_id' => $program_id, 'type' => Module::TIME_DISTRIBUTION_TYPE])
            ->one();
    }
}
