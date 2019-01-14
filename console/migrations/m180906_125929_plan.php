<?php

use yii\db\Migration;

/**
 * Class m180906_125929_plan
 */
class m180906_125929_plan extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $options = null;
      if ( $this->db->driverName=='mysql' ) {
        $options = 'CHARACTER SET utf8 COLLATE utf8_spanish_ci ENGINE=innodb';
      }
      $this->createTable('{{%plan}}',[
        'id'      =>  $this->primaryKey(),
        'planordenanza'   =>  $this->string()->notNull(),
        'carrera_id' => $this->integer(),
      ], $options);
      $this->addForeignKey(
        'carreraplan',
        'plan',
        'carrera_id',
        'carrera',
        'id',
        'no action',
        'no action'
      );
      $this->insert('{{%plan}}', [
          'id' => 1,
          'planordenanza' => 'Ord. 895/12',
          'carrera_id' => '1',
      ]);
      $this->insert('{{%plan}}', [
          'id' => 2,
          'planordenanza' => 'Ord. 885/12',
          'carrera_id' => '2',
      ]);
      $this->insert('{{%plan}}', [
          'id' => 3,
          'planordenanza' => 'Ord. 962/98',
          'carrera_id' => '3',
      ]);
      $this->insert('{{%plan}}', [
          'id' => 4,
          'planordenanza' => 'Ord. 432/09',
          'carrera_id' => '4',
      ]);
      $this->insert('{{%plan}}', [
          'id' => 5,
          'planordenanza' => 'Ord. 431/09',
          'carrera_id' => '8',
      ]);
      $this->insert('{{%plan}}', [
          'id' => 6,
          'planordenanza' => 'Ord. 1215/13',
          'carrera_id' => '6',
      ]);
      $this->insert('{{%plan}}', [
          'id' => 7,
          'planordenanza' => 'N/N',
          'carrera_id' => '7',
      ]);
      $this->insert('{{%plan}}', [
          'id' => 8,
          'planordenanza' => 'Ord. 814/01',
          'carrera_id' => '5',
      ]);
      $this->insert('{{%plan}}', [
          'id' => 9,
          'planordenanza' => 'Ord. 605/11',
          'carrera_id' => '9',
      ]);
      $this->insert('{{%plan}}', [
          'id' => 10,
          'planordenanza' => 'N/N',
          'carrera_id' => '10',
      ]);
      $this->insert('{{%plan}}', [
          'id' => 11,
          'planordenanza' => 'Ord. 374/11',
          'carrera_id' => '11',
      ]);
      $this->insert('{{%plan}}', [
          'id' => 12,
          'planordenanza' => 'N/N',
          'carrera_id' => '12',
      ]);
      $this->insert('{{%plan}}', [
          'id' => 13,
          'planordenanza' => 'Ord. 374/11',
          'carrera_id' => '13',
      ]);
      $this->insert('{{%plan}}', [
          'id' => 14,
          'planordenanza' => 'Ord. 1031/12',
          'carrera_id' => '14',
      ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropForeignKey('carreraplan','{{%carrera}}');
      $this->dropTable('{{%plan}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190103_182753_plan cannot be reverted.\n";

        return false;
    }
    */
}
