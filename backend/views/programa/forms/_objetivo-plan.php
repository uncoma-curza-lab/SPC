<?php
use kartik\tabs\TabsX;
use froala\froalaeditor\FroalaEditorWidget;
 ?>
<h3>2. Objetivo según Plan de estudio</h3>
<?= TabsX::widget([
  'position' => TabsX::POS_LEFT,
  'align' => TabsX::ALIGN_LEFT,
  'encodeLabels' => false,
  'items' => [
    [
      'label' => 'Descripcion',
      'content' =>  FroalaEditorWidget::widget([
                  'model' => $model,
                  'attribute' => 'objetivo_plan',
                  'name' => 'objetivo_plan',
                  'options' => [
                      'id'=>'objetivo_plan'
                  ]
      ])
    ],
    [
      'label' => 'Puntos',
      'content' =>  $this->render('_objetivos',['model' => $model, 'form' => $form])
    ]
  ]
])?>
