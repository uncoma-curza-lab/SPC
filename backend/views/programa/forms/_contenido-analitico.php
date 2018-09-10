<?php
use kartik\tabs\TabsX;
 ?>
<h3>4. Contenidos analíticos</h3>
<?= TabsX::widget([
  'position' => TabsX::POS_LEFT,
  'align' => TabsX::ALIGN_LEFT,
  'encodeLabels' => false,
  'items' => [
    [
      'label' => 'Unidad I',
      'content' =>  'temas'
    ],
    [
      'label' => 'Unidad II',
      'content' => 'temas'
    ]
  ]
])?>
