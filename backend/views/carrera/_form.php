<?php
use dosamigos\tinymce\TinyMce;

use yii\helpers\Html;
use yii\widgets\ActiveForm;
  use kartik\select2\Select2;
  use yii\helpers\ArrayHelper;
use common\models\Departamento;
use common\models\Plan;
use common\models\Modalidad;
use common\models\Nivel;
/* @var $this yii\web\View */
/* @var $model backend\models\Carrera */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="carrera-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-4">
      <?= $form->field($model, 'nom')->textInput(['maxlength' => true])->label("Nombre") ?>

      <?= $form->field($model, 'codigo')->textInput() ?>
     
      
    </div>
    <div class="col-md-4">
    <?= $form->field($model, 'duracion_total_anos')->input('float') ?>
      <?= $form->field($model, 'duracion_total_hs')->input('integer') ?>
    </div>
    <div class="col-md-4">
    
    <?= $form->field($model, 'departamento_id')->widget(Select2::classname(),[
        'data' => ArrayHelper::map(Departamento::find()->all(),'id','nomenclatura'),
        //'data' =>ArrayHelper::map(((new StatusSearch())->search(['model' => 'backend\models\Status'])),'id','descripcion'),
        //'data' => (new StatusSearch())->search(['model' => 'backend\models\Status'])->id,
        'language' => 'es',
        'options' => ['placeholder' => 'Seleccione un departamento...'],
        'pluginOptions' => [
          'allowClear' => true,
        ],
    ]) ?>
     <?= $form->field($model, 'nivel_id')->widget(Select2::classname(),[
        'data' => ArrayHelper::map(Nivel::find()->all(),'id','descripcion'),
        'language' => 'es',
        'options' => ['placeholder' => 'Seleccione un nivel...'],
        'pluginOptions' => [
          'allowClear' => true,
        ],
    ]) ?>
 
    <?php  if ($model->id){
            echo $form->field($model, 'plan_vigente_id')->widget(Select2::classname(),[
              'data' => ArrayHelper::map(Plan::find()->where(['=','carrera_id',$model->id])->all(),'id','planordenanza'),
              //'data' =>ArrayHelper::map(((new StatusSearch())->search(['model' => 'backend\models\Status'])),'id','descripcion'),
              //'data' => (new StatusSearch())->search(['model' => 'backend\models\Status'])->id,
              'language' => 'es',
              'options' => ['placeholder' => 'Seleccione un plan...'],
              'pluginOptions' => [
                'allowClear' => true,
              ],
            ]);
          }  
    ?>
    </div>
    <?= $form->field($model, 'alcance')->widget(TinyMce::className(), [
    'options' => ['rows' => 16],
    'language' => 'es',
    'clientOptions' => [
        'plugins' => [
            "advlist autolink lists link charmap
            "//print
            ."preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime  table contextmenu paste"
        ],
        'branding' => false,
        'toolbar' => "table | undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | fullscreen "
    ]
])->label('Alcance') ?>
    <?= $form->field($model, 'fundamentacion')->widget(TinyMce::className(), [
    'options' => ['rows' => 16],
    'language' => 'es',
    'clientOptions' => [
        'plugins' => [
            "advlist autolink lists link charmap
            "//print
            ."preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime  table contextmenu paste"
        ],
        'branding' => false,
        'toolbar' => "table | undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | fullscreen "
    ]
])->label('Fundamentacion') ?>
    
  <?= $form->field($model, 'perfil')->widget(TinyMce::className(), [
    'options' => ['rows' => 16],
    'language' => 'es',
    'clientOptions' => [
        'plugins' => [
            "advlist autolink lists link charmap
            "//print
            ."preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime  table contextmenu paste"
        ],
        'branding' => false,
        'toolbar' => "table | undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | fullscreen "
    ]
  ])->label('Perfil') ?>


 
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
