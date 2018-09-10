<?php
use kartik\tabs\TabsX;
 ?>
<h3>10. Cronograma Tentativo</h3>
<?= TabsX::widget([
  'position' => TabsX::POS_LEFT,
  'align' => TabsX::ALIGN_LEFT,
  'encodeLabels' => false,
  'items' => [
    [
      'label' => 'Calendario',
      'content' => 'calendario'
    ],
  ],
])?>
