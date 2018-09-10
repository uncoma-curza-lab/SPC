<?php
use froala\froalaeditor\FroalaEditorWidget;
 ?>
<h3>6. Propuesta Metodológica</h3>

<?= FroalaEditorWidget::widget([
            'model' => $model,
            'attribute' => 'propuesta_met',
            'name' => 'propuesta_met',
            'options' => [
                'id'=>'propuesta_met'
            ]
]) ?>
