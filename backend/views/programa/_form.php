<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\tabs\TabsX;
use froala\froalaeditor\FroalaEditorWidget;
/* @var $this yii\web\View */
/* @var $model backend\models\Programa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="programa-form">

    <?php $form = ActiveForm::begin(); ?>

        <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>
    <h3>Programa</h3>
    <?= $this->render('_portada',['model'=>$model]); ?>
    <?= $this->render('forms/_fundamentacion',['model'=>$model]); ?>
    <?= $this->render('forms/_objetivo-plan',['model'=>$model, 'form' => $form]); ?>
    <?= $this->render('forms/_contenido-plan',['model'=>$model]); ?>
    <?= $this->render('forms/_contenido-analitico',['model'=>$model]); ?>
    <?= $this->render('forms/_biblio-byc',['model'=>$model]); ?>
    <?= $this->render('forms/_propuesta-metodologica',['model'=>$model]); ?>
    <?= $this->render('forms/_eval-acred',['model'=>$model]); ?>
    <?= $this->render('forms/_parc-rec-promo',['model'=>$model]); ?>
    <?= $this->render('forms/_dist-horaria',['model'=>$model]); ?>
    <?= $this->render('forms/_crono-tentativo',['model'=>$model]); ?>
    <?= $this->render('forms/_activ-extrac',['model'=>$model]); ?>

    <?php ActiveForm::end(); ?>

</div>
