<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\models\Carrera;
use common\models\Modalidad;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\correlativa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cmodalidad-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'carrera_id')->widget(Select2::classname(),[
        'data' => ArrayHelper::map(Carrera::find()->all(),'id', 'nomenclatura'),
        'language' => 'es',
        'options' => ['placeholder' => 'Seleccione una carrera'],
        'pluginOptions' => [
          'allowClear' => true,
        ],
      ]) ?>
      <?= $form->field($model, 'modalidad_id')->widget(Select2::classname(),[
        'data' => ArrayHelper::map(Modalidad::find()->all(),'id', 'nombre'),
        'language' => 'es',
        'options' => ['placeholder' => 'Seleccione una modalidad'],
        'pluginOptions' => [
          'allowClear' => true,
        ],
      ]) ?>
      
 

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
