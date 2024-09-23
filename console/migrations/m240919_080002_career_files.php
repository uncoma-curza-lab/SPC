<?php

use yii\db\Migration;

class m240919_080002_career_files extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%carrera}}', 'related_files', $this->json());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%carrera}}', 'related_files');
    }
}
