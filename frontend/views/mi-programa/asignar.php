<?php

use yii\helpers\Html;
use dosamigos\tinymce\TinyMce;


use yii\widgets\ActiveForm;
use common\models\Cargo;
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

    <?php $form = ActiveForm::begin([
      'enableAjaxValidation'      => false,
      'enableClientValidation'    => false,
      'validateOnChange'          => true,
      'validateOnSubmit'          => false,
      'validateOnBlur'            => false,
    ]); ?>

    <!--<? $form->field($designacion, 'cargo_id')->widget(Select2::classname(),[
        'data' => ArrayHelper::map(Cargo::find()->all(),'id','nomenclatura'),
        //'data' =>ArrayHelper::map(((new StatusSearch())->search(['model' => 'backend\models\Status'])),'id','descripcion'),
        //'data' => (new StatusSearch())->search(['model' => 'backend\models\Status'])->id,
        'language' => 'es',
        'options' => ['placeholder' => 'Seleccione un estado'],
        'pluginOptions' => [
          'allowClear' => true,
        ],
      ]) ?>
      <? $form->field($designacion, 'user_id')->widget(Select2::classname(),[
          'data' => ArrayHelper::map(User::find()->all(),'id','username'),
          //'data' =>ArrayHelper::map(((new StatusSearch())->search(['model' => 'backend\models\Status'])),'id','descripcion'),
          //'data' => (new StatusSearch())->search(['model' => 'backend\models\Status'])->id,
          'language' => 'es',
          'options' => ['placeholder' => 'Seleccione un usuario'],
          'pluginOptions' => [
            'allowClear' => true,
          ],
        ]) ?>
    <? $form->field($designacion, 'programa_id')->textInput() ?> -->
    <h3>Equipo de cátedra</h3>
    <?= $form->field($model, 'equipo_catedra')->widget(TinyMce::className(), [
        'options' => ['rows' => 12],
        'language' => 'es',
        'clientOptions' => [
            'plugins' => [
                "advlist autolink lists link charmap
                "//print
                ."preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime  table contextmenu paste"
            ],
            'toolbar' => "fullscreen | undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link| table "
        ]
    ])->label('') ?>
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
