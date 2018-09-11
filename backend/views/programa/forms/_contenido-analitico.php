<?php
use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\MultipleInputColumn;

 ?>
<h3>4. Contenidos analíticos</h3>
<?=
 $form->field($model,'unidades')->widget(
    MultipleInput::className(),[
      'model' => $model,
      //'cloneButton' => true,
      'allowEmptyList' => false,

      'columns' => [
        [
          'title' => "titulo de unidad",
          'name' => 'descripcion',
        ],
        [
            'name' => 'temas',
            'type'  => MultipleInput::class,
            'options' => [
                'columns' => [
                    [
                        'title' => 'Temas',
                        'name' => 'temas',

                    ]
                ]
            ]
        ]
        /*[
          'name'=> 'programa_id',
        ]*/
      ],
      'addButtonPosition' => [
              //MultipleInput::POS_HEADER,
              MultipleInput::POS_FOOTER,
              MultipleInput::POS_ROW
          ]
    ]);
 ?>
