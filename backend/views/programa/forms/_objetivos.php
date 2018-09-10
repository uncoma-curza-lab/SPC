<?php use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\MultipleInputColumn; ?>
<?=

MultipleInput::widget([
    'model' => $model,
    'attribute' => 'objetivo_plan',
    'min' => 1,
    'allowEmptyList' => false,
    'columns' => [
      [
          'name' => 'objetivo_plan',
          'options' => [
              'placeholder' => 'Objetivo'
          ]
      ]
    ],
    'addButtonPosition' => [
            //MultipleInput::POS_HEADER,
            MultipleInput::POS_FOOTER,
            MultipleInput::POS_ROW
        ]
])
 ?>
