<?php
use froala\froalaeditor\FroalaEditorWidget;
 ?>
<h3>8. Parciales, Recuperatorios y coloquios</h3>

<?= FroalaEditorWidget::widget([
            'model' => $model,
            'attribute' => 'parcial_rec_promo',
            'name' => 'parcial_rec_promo',
            'options' => [
                'id'=>'parcial_rec_promo'
            ]
]) ?>
