<?php

use yii\helpers\Html;


use yii\widgets\ActiveForm;
use backend\models\Cargo;
use common\models\User;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Programa */

$this->title = 'Asignar Programa';
$this->params['breadcrumbs'][] = ['label' => 'Programas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="designacion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($designacion, 'cargo_id')->widget(Select2::classname(),[
        'data' => ArrayHelper::map(Cargo::find()->all(),'id','nomenclatura'),
        //'data' =>ArrayHelper::map(((new StatusSearch())->search(['model' => 'backend\models\Status'])),'id','descripcion'),
        //'data' => (new StatusSearch())->search(['model' => 'backend\models\Status'])->id,
        'language' => 'es',
        'options' => ['placeholder' => 'Seleccione un estado'],
        'pluginOptions' => [
          'allowClear' => true,
        ],
      ]) ?>
      <?= $form->field($designacion, 'user_id')->widget(Select2::classname(),[
          'data' => ArrayHelper::map(User::find()->all(),'id','username'),
          //'data' =>ArrayHelper::map(((new StatusSearch())->search(['model' => 'backend\models\Status'])),'id','descripcion'),
          //'data' => (new StatusSearch())->search(['model' => 'backend\models\Status'])->id,
          'language' => 'es',
          'options' => ['placeholder' => 'Seleccione un usuario'],
          'pluginOptions' => [
            'allowClear' => true,
          ],
        ]) ?>
    <?= $form->field($designacion, 'programa_id')->textInput() ?>
    <div class="form-group">
      <?= Html::submitButton('Guardar y salir',['class' => 'btn btn-info' , 'name'=>'submit','value' => 'salir']) ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
