<?php
use froala\froalaeditor\FroalaEditorWidget;
 ?>
<h3>7. Evaluación y condiciones de acreditación</h3>
<?= FroalaEditorWidget::widget([
            'model' => $model,
            'attribute' => 'evycond_acreditacion',
            'name' => 'evycond_acreditacion',
            'options' => [
                'id'=>'evycond_acreditacion'
            ]
]) ?>
