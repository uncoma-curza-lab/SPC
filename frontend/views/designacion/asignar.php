<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Cargo;
use common\models\User;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$this->title = 'Asignar nuevo cargo';
$this->params['breadcrumbs'][] = ['label' => 'Programas', 'url' => ['programa/index']];
$this->params['breadcrumbs'][] = $model->getPrograma()->one()->getAsignatura()->one()->nomenclatura;

/* @var $this yii\web\View */
/* @var $model backend\models\Designacion */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="designacion-form">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin([
        'enableAjaxValidation'      => false,
        'enableClientValidation'    => false,
        'validateOnChange'          => true,
        'validateOnSubmit'          => false,
        'validateOnBlur'            => false,
    ]);  ?>
    <?= $form->field($model, 'cargo_id')->widget(Select2::classname(),[
        'data' => ArrayHelper::map(Cargo::find()->all(),'id','nomenclatura'),
        'attribute' => 'cargo_id',
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


    <div class="form-group">
        <?= Html::submitButton('Confirmar', ['class' => 'btn btn-success']) ?>
        <?= Html::submitButton('Confirmar y asignar otro cargo', ['class' => 'btn btn-info', 'name'=>'submit','value' => 'seguir']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
