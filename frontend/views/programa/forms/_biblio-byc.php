<?php
use kartik\tabs\TabsX;
 ?>
<h3>5. Bibliografía básica y de consulta</h3>
<?= TabsX::widget([
  'position' => TabsX::POS_LEFT,
  'align' => TabsX::ALIGN_LEFT,
  'encodeLabels' => false,
  'items' => [
    [
      'label' => 'Bibliografía basica',
      'content' => $this->render('_biblioBasicas', ['model'=>$model])
    ],
    [
      'label' => 'Bibliografía de consulta',
      'content' => $this->render('_biblioConsultas', ['model'=>$model])
    ]
  ]
])?>
