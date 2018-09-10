<?php
use froala\froalaeditor\FroalaEditorWidget;
 ?>
<h3>11. Planificación de actividades Extracurriculares</h3>
<?= FroalaEditorWidget::widget([
            'model' => $model,
            'attribute' => 'actv_extracur',
            'name' => 'actv_extracur',
            'options' => [
                'id'=>'actv_extracur'
            ]
]) ?>
