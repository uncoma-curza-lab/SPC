<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use froala\froalaeditor\FroalaEditorWidget;

/* @var $this yii\web\View */
/* @var $model backend\models\Observacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="observacion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= FroalaEditorWidget::widget([
                'model' => $model,
                'attribute' => 'texto',
                'name' => 'texto',
                'options' => [
                    'id'=>'texto'
                ],
                'clientOptions' => [
                  'placeholderText' => 'Ingrese las observaciones para que el profesor pueda corregir el programa',
                  'height' => 100,
                  'language' => 'es',
                  'height' => 100,
                  'theme' => 'gray',
                  'toolbarButtons' => ['bold', 'italic', 'underline', '|', 'paragraphFormat', 'fontSize','color','|','undo','redo','align'],
                ],
    ]) ?>

  
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
