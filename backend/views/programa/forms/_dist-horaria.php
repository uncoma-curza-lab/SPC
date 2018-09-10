<?php
use froala\froalaeditor\FroalaEditorWidget;
 ?>
<h3>9. Distribución horaria</h3>
<?= FroalaEditorWidget::widget([
            'model' => $model,
            'attribute' => 'distr_horaria',
            'name' => 'distr_horaria',
            'options' => [
                'id'=>'distr_horaria'
            ]
]) ?>
