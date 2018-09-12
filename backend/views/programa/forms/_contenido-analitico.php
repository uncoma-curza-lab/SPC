<?php
use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\MultipleInputColumn;
use froala\froalaeditor\FroalaEditorWidget;
use yii\jui\DatePicker;
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
        ],
        [
          'title' => 'Bibliografía basica',
          'name' => 'biblio_basica',
          'type' =>  FroalaEditorWidget::class,
          'options' => [
            'clientOptions' => [
              'height' => 100,
              'language' => 'es',
              'height' => 100,
              'theme' => 'gray',
              'toolbarButtons' => ['bold', 'italic', 'underline', '|', 'paragraphFormat', 'fontSize','color','|','undo','redo','align'],
            ],

          ]
        ],
        [
          'title' => 'Bibliografía consulta',
          'name' => 'biblio_consulta',
          'type' =>  FroalaEditorWidget::class,
          'options' => [
            'clientOptions' => [
              'language' => 'es',
              'height' => 100,
              'theme' => 'gray',
              'toolbarButtons' => ['bold', 'italic', 'underline', '|', 'paragraphFormat', 'fontSize','color','|','undo','redo','align'],
            ],

          ]
        ],
        [
          'title' => 'fecha p/ cronograma tentativo',
          'name' => 'crono_tent',
          'type' => DatePicker::class,
          'options' =>[
            'dateFormat' => 'yyyy-MM-dd'
          ]
        ],
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
