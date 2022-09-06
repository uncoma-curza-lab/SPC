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
