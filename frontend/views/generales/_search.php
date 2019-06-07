<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\ProgramaSearch */
/* @var $form yii\widgets\ActiveForm */
use common\models\Asignatura;
use common\models\Departamento;
use common\models\Status;

?>

<div class="programa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <?= $form->field($model, 'departamento')->widget(Select2::classname(),[
        'data' => ArrayHelper::map(Departamento::find()->all(),
                   'nom',
                    'nom' ),
        'language' => 'es',
        'options' => ['placeholder' => 'Seleccione un departamento...'],
        'pluginOptions' => [
          'allowClear' => true,
        ],
      ]) ?>

      <?= $form->field($model, 'status')->widget(Select2::classname(),[
          'data' => ArrayHelper::map(Status::find()->all(),
                     'descripcion',
                      'descripcion' ),
          'language' => 'es',
          'options' => ['placeholder' => 'Seleccione un estado'],
          'pluginOptions' => [
            'allowClear' => true,
          ],
        ]) ?>
    <?= $form->field($model, 'asignatura')->widget(Select2::classname(),[
        'data' => ArrayHelper::map(Asignatura::find()->all(),
                    'nomenclatura',
                    'nomenclatura',
                    function($model,$e){
                      $dep = $model->getDepartamento()->one();
                      return isset($dep) ? $dep->nom : "N";
                    }
                  ),
        //'data' =>ArrayHelper::map(((new StatusSearch())->search(['model' => 'backend\models\Status'])),'id','descripcion'),
        //'data' => (new StatusSearch())->search(['model' => 'backend\models\Status'])->id,

        'language' => 'es',
        'options' => ['placeholder' => 'Seleccione una asignatura'],
        'pluginOptions' => [
          'allowClear' => true,
        ],
      ]) ?>


    <?php  echo $form->field($model, 'year') ?>

    <?php // echo $form->field($model, 'cuatrimestre') ?>

    <?php // echo $form->field($model, 'fundament') ?>

    <?php // echo $form->field($model, 'objetivo_plan') ?>

    <?php // echo $form->field($model, 'contenido_plan') ?>

    <?php // echo $form->field($model, 'propuesta_met') ?>

    <?php // echo $form->field($model, 'evycond_acreditacion') ?>

    <?php // echo $form->field($model, 'parcial_rec_promo') ?>

    <?php // echo $form->field($model, 'distr_horaria') ?>

    <?php // echo $form->field($model, 'crono_tentativo') ?>

    <?php // echo $form->field($model, 'actv_extracur') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Limpiar', ['index'],['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
