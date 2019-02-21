<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
/* @var $this yii\web\View */
/* @var $model backend\models\Tema */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tema-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->widget(TinyMce::className(), [
        'options' => ['rows' => 6],
        'language' => 'es',
        'clientOptions' => [
            'plugins' => [
                "advlist autolink lists link charmap
                "//print
                ."preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime  table contextmenu paste"
            ],
            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link "
        ]
    ]) ?>

    <div class="form-group">
      <div class="row">

      </div>
    </div>
    <div class="form-group">
        <div class="row">
          <div class="col-xs-6 text-left">
            <?= Html::a('Volver', ['unidad/update', 'id' => $model->unidad_id],['class' => 'btn btn-warning']) ?>
          </div>
          <div class="col-xs-6 text-right">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success'])  ?>
          </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
