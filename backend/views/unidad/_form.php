<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use froala\froalaeditor\FroalaEditorWidget;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model backend\models\Unidad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unidad-form">

    <?php $form = ActiveForm::begin(); ?>



    <?= $form->field($model, 'descripcion')->widget(FroalaEditorWidget::className(), [
        'attribute' => 'descripcion',
        'name' => 'descripcion',
        'options' => [
            'id'=>'descripcion',
        ],
        'clientOptions' => [
          'height' => 100,
          'language' => 'es',
          'height' => 100,
          'theme' => 'gray',
          'toolbarButtons' => ['bold', 'italic', 'underline', '|', 'paragraphFormat', 'fontSize','color','|','undo','redo','align'],
        ],

      ]) ?>

    <div class="row">
      <div class="col-xs-6">
        <?= $form->field($model, 'biblio_basica')->widget(FroalaEditorWidget::className(), [
            'attribute' => 'biblio_basica',
            'name' => 'biblio_basica',
            'options' => [
                'id'=>'biblio_basica',
            ],
            'clientOptions' => [
              'height' => 100,
              'language' => 'es',
              'height' => 100,
              'theme' => 'gray',
              'toolbarButtons' => ['bold', 'italic', 'underline', '|', 'paragraphFormat', 'fontSize','color','|','undo','redo','align'],
            ],
          ]) ?>
      </div>
      <div class="col-xs-6">
        <?= $form->field($model, 'biblio_consulta')->widget(FroalaEditorWidget::className(), [
            'attribute' => 'biblio_consulta',
            'name' => 'biblio_consulta',
            'options' => [
                'id'=>'biblio_consulta',
            ],
            'clientOptions' => [
              'height' => 100,
              'language' => 'es',
              'height' => 100,
              'theme' => 'gray',
              'toolbarButtons' => ['bold', 'italic', 'underline', '|', 'paragraphFormat', 'fontSize','color','|','undo','redo','align'],
            ],
          ]) ?>
      </div>
    </div>
    <div class="row">
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
    </div>
    <div class="form-group">
        <?php
          if(!isset($model->id)) {
            $buton= 'Guardar y agregar temas';
          } else {
            $buton= 'Guardar';
          }
        ?>
        <div class="row">
          <?= Html::submitButton(''.$buton, ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php if ( isset($model->id) ) {?>
    <hr>
    <h1>Temas</h1>
    <?= $this->render('_gridTemas',['model' => $model]) ?>
    <?php } ?>

    <?php ActiveForm::end(); ?>


</div>
