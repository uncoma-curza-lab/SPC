<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model backend\models\Unidad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unidad-form">

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

    <div class="row">
      <div class="col-xs-6">
        <?= $form->field($model, 'biblio_basica')->widget(TinyMce::className(), [
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
      </div>
      <div class="col-xs-6">
        <?= $form->field($model, 'biblio_consulta')->widget(TinyMce::className(), [
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
      </div>
    </div>
  <!--  <div class="row">
      <div class="col-xs-4">
        <?= $form->field($model, 'crono_tent')->widget(DatePicker::className(),[
          'language' => 'es',
          'dateFormat' => 'yyyy-MM-dd',

          'options' =>[
            'showAnim' => 'blind',
            'changeYear'=>false,
            'showButtonPanel'=>true,
            'yearRange'=>'2000:2099',
            'minDate' => '2000-01-01',      // minimum date
            'maxDate' => '2099-12-31',      // maximum date
          ],
          ]) ?>
      </div>
    </div>-->

    <div class="form-group">
        <div class="row">
          <div class="col-xs-6 text-left">
            <?= Html::a('Volver al programa', ['programa/contenido-analitico', 'id' => $model->programa_id],['class' => 'btn btn-warning']) ?>
          </div>
          <div class="col-xs-6 text-right">
            <?php
              if(!isset($model->id)) {
                $button= 'Guardar y agregar temas';
              } else {
                $button= 'Guardar';
              }
            ?>
            <div class="row">
              <?= Html::submitButton(''.$button, ['class' => 'btn btn-success']) ?>

            </div>
          </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>


</div>
