<?php
use kartik\tabs\TabsX;
use yii\jui\DatePicker;
 ?>
<h3>10. Cronograma Tentativo</h3>
<?php echo DatePicker::widget([
    'model' => $model,
    'attribute' => 'from_date',
    //'language' => 'ru',
    //'dateFormat' => 'yyyy-MM-dd',
]); ?>
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
