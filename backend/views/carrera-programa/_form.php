<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\Carrera;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\CarreraPrograma */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="carrera-programa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'carrera_id')->widget(Select2::classname(),[
        'data' => ArrayHelper::map(Carrera::find()->all(),'id','nom'),
        'language' => 'es',
        'options' => ['placeholder' => 'Seleccione una Carrera'],
        'pluginOptions' => [
          'allowClear' => true,
        ],
      ]) ?>


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
