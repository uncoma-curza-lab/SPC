<?php
use yii\helpers\Html;

use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model backend\models\Programa */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin([
  'enableAjaxValidation'      => true,
  'enableClientValidation'    => false,
  'validateOnChange'          => false,
  'validateOnSubmit'          => true,
  'validateOnBlur'            => false,
]); ?>



  <?= $this->render('_fundamentacion',['model'=>$model, 'form' => $form]); ?>
  <?= $this->render('_objetivo-plan',['model'=>$model, 'form' => $form]); ?>
  <?= $this->render('_contenido-plan',['model'=>$model, 'form' => $form]); ?>
  <?= $this->render('_contenido-analitico',['model'=>$model, 'form' => $form]); ?>
  <!--<?= $this->render('_biblio-byc',['model'=>$model, 'form' => $form]); ?>-->
  <?= $this->render('_propuesta-metodologica',['model'=>$model, 'form' => $form]); ?>
  <?= $this->render('_eval-acred',['model'=>$model, 'form' => $form]); ?>
  <?= $this->render('_parc-rec-promo',['model'=>$model, 'form' => $form]); ?>
  <?= $this->render('_dist-horaria',['model'=>$model, 'form' => $form]); ?>
  <?= $this->render('_crono-tentativo',['model'=>$model, 'form' => $form]); ?>
  <?= $this->render('_activ-extrac',['model'=>$model, 'form' => $form]); ?>
  <div class="form-group">
      <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
  </div>
<?php ActiveForm::end(); ?>
