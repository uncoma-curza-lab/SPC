<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\tabs\TabsX;
use froala\froalaeditor\FroalaEditorWidget;
 use unclead\multipleinput\MultipleInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Programa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="programa-form">

    <?php $form = ActiveForm::begin(); ?>

        <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>
        <?=
         $form->field($model,'objetivos')->widget(
            MultipleInput::className(),[
              'model' => $model,
              'allowEmptyList' => false,

              'addButtonPosition' => [
                      //MultipleInput::POS_HEADER,
                      MultipleInput::POS_FOOTER,
                      MultipleInput::POS_ROW
                  ]
            ]);
         ?>
    <h3>Programa</h3>
    <?= $this->render('_portada',['model'=>$model]); ?>

    <?php ActiveForm::end(); ?>

</div>
