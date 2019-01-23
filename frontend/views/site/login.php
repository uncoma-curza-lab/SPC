<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Acceso';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login text-center">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Complete los siguientes campos para ingresar.</p>

    <div class="row" ">
        <div class="col-lg-offset-4 col-lg-4 ">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Usuario') ?>

                <?= $form->field($model, 'password')->passwordInput()->label('Contraseña') ?>

                <?= $form->field($model, 'rememberMe')->checkbox()->label('Recordarme') ?>

                <div style="color:#999;margin:1em 0">
                    Si perdió su contraseña haga <?= Html::a('click aquí', ['site/request-password-reset']) ?>.
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Ingresar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
