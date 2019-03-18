<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Acceso';
//$this->params['breadcrumbs'][] = $this->title;
?>
  <div class="site-login container" >

    <div class="col-md-6 col-md-offset-6">

      <div class="row" >
          <div class="col-lg-offset-4 col-lg-6 text-center ">

              <h1><?= Html::encode($this->title) ?></h1>

              <p>Complete los siguientes campos para ingresar.</p>

              <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                  <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Usuario') ?>

                  <?= $form->field($model, 'password')->passwordInput()->label('Contraseña') ?>

                  <?= $form->field($model, 'rememberMe')->checkbox()->label('Recordarme') ?>

                  <div style="color:#999;margin:1em 0">
                      Si perdió su contraseña comunicarse con el Departamento de Ciencia y Tecnología (C.U.R.Z.A.)
                  </div>

                  <div class="form-group">
                      <?= Html::submitButton('Ingresar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                  </div>

              <?php ActiveForm::end(); ?>
          </div>
      </div>
    </div>
  </div>
