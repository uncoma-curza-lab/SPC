<?php use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\MultipleInputColumn;
use backend\models\Objetivo;
use yii\data\ActiveDataProvider;
?>
<?=
 $form->field($model,'objetivos')->widget(
    MultipleInput::className(),[
      'model' => $model,
      'allowEmptyList' => false,
      'columns' => [
        [
          'name' => 'descripcion',
        ],
        [
          'name'=> 'programa_id',
        ]
      ],
      'addButtonPosition' => [
              //MultipleInput::POS_HEADER,
              MultipleInput::POS_FOOTER,
              MultipleInput::POS_ROW
          ]
    ]);
 ?>
