<?php

use yii\db\Migration;

/**
 * Class m221106_233335_add_new_lesson_types
 */
class m221106_233335_add_new_lesson_types extends Migration
{
    const DESCRIPTIONS = [
        [
            'Presencialidad en el establecimiento',
            100,
        ],
        [
            'Presencialidad remota',
            100,
        ],
        [
            'EAD Asincronica - PEDCO',
            45,
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        echo 'Add new lesson types.\n';

        $this->batchInsert(
            '{{%lesson_types}}',
            [
                'description',
                'max_use_percentage',
            ],
            self::DESCRIPTIONS
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo 'Delete new lesson types.\n';

        foreach(self::DESCRIPTIONS as $description) {
            $this->delete('{{%lesson_types}}', ['description' => $description[0]]);
        }
            
    }
}
