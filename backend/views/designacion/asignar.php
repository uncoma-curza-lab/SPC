<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Cargo;
use common\models\User;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\Designacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="designacion-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'cargo_id')->widget(Select2::classname(),[
        'data' => ArrayHelper::map(Cargo::find()->all(),'id','nomenclatura'),
        'language' => 'es',
        'options' => ['placeholder' => 'Seleccione una asignatura'],
        'pluginOptions' => [
          'allowClear' => true,
        ],
      ]) ?>

      <?= $form->field($model, 'user_id')->widget(Select2::classname(),[
          'data' => ArrayHelper::map(User::find()->all(),'id','username'),
          'language' => 'es',
          'options' => ['placeholder' => 'Seleccione una asignatura'],
          'pluginOptions' => [
            'allowClear' => true,
          ],
        ]) ?>

    <?= $form->field($model, 'programa_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
