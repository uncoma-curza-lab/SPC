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
      'content' =>  $this->render('_objetivos',['model' => $model])
    ],
    [
      'label' => 'Unidades',
      'content' => 'Añadir más'
    ]
  ]
])?>
