<?php
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PermisosHelpers;
use common\models\Status;

/* @var $this yii\web\View */
/* @var $model common\models\user */
 
$show_this_nav = PermisosHelpers::requerirMinimoRol('SuperUsuario');
 
$this->params['breadcrumbs'][] = ['label' => 'Cambiar de estado de programas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
 
    <h1><?= Html::encode($this->title) ?></h1>
 
     <p>
 
     <?php $form = ActiveForm::begin([
      'enableAjaxValidation'      => false,
      'enableClientValidation'    => false,
      'validateOnChange'          => true,
      'validateOnSubmit'          => false,
      'validateOnBlur'            => false,
    ]); ?>
    <?= $form->field($model,'current_status')->widget(Select2::class,[
          'data' => ArrayHelper::map(Status::find()->all(),'id','descripcion'),
          'language' => 'es',
          'options' => ['placeholder' => 'Seleccione estado actual de los programas'],
          'pluginOptions' => [
            'allowClear' => true,
          ],
        ])->label("Estado actual") ?>

    <?= $form->field($model, 'year')->textInput(['maxlength' => true])->label("Año") ?>

    <?= $form->field($model,'set_status')->widget(Select2::class,[
          'data' => ArrayHelper::map(Status::find()->all(),'id','descripcion'),
          //'data' =>ArrayHelper::map(((new StatusSearch())->search(['model' => 'backend\models\Status'])),'id','descripcion'),
          //'data' => (new StatusSearch())->search(['model' => 'backend\models\Status'])->id,
          'language' => 'es',
          'options' => ['placeholder' => 'Seleccione estado a cambiar'],
          'pluginOptions' => [
            'allowClear' => true,
          ],
        ])->label("Estado al que cambiará") ?>
   <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
 
</div>
