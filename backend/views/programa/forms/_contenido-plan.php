<?php
use froala\froalaeditor\FroalaEditorWidget;
 ?>
<h3>3. Contenido según Plan de Estudio</h3>
<?= FroalaEditorWidget::widget([
            'model' => $model,
            'attribute' => 'contenido_plan',
            'name' => 'contenido_plan',
            'options' => [
                'id'=>'contenido_plan'
            ]
]) ?>
