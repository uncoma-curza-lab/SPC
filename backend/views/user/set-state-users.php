<?php
use yii\widgets\ActiveForm;
use backend\models\Estado;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PermisosHelpers;
 
/* @var $this yii\web\View */
/* @var $model common\models\user */
 
$show_this_nav = PermisosHelpers::requerirMinimoRol('SuperUsuario');
 
$this->params['breadcrumbs'][] = ['label' => 'Acciones generales', 'url' => ['index']];
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
    <?= $form->field($model,'estado')->widget(Select2::classname(),[
          'data' => ArrayHelper::map(Estado::find()->all(),'id','estado_nombre'),
          //'data' =>ArrayHelper::map(((new StatusSearch())->search(['model' => 'backend\models\Status'])),'id','descripcion'),
          //'data' => (new StatusSearch())->search(['model' => 'backend\models\Status'])->id,
          'language' => 'es',
          'options' => ['placeholder' => 'Seleccione un usuario'],
          'pluginOptions' => [
            'allowClear' => true,
          ],
        ]) ?>
   <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
 
</div>
