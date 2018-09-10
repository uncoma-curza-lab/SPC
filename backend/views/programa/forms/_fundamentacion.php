<?php use froala\froalaeditor\FroalaEditorWidget; ?>
<h3>1. Fundamentación</h3>
<?= FroalaEditorWidget::widget([
            'model' => $model,
            'attribute' => 'fundament',
            'name' => 'fundament',
            'options' => [
                'id'=>'fundament'
            ]
]) ?>
