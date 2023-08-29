<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\typeahead\TypeaheadBasic;
use frontend\models\Perfil;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model frontend\models\Perfil */
/* @var $form yii\widgets\ActiveForm */


$photoInfo = $model->PhotoInfo;
$photo = Html::img($photoInfo['url'],['alt'=>$photoInfo['alt']]);

//$cargosData=Perfil::listaCargos();
//$localidadesData=Perfil::listaLocalidades();
?>

<div class="perfil-form">

    <?php $form = ActiveForm::begin([
     "method" => "post",
     "enableClientValidation" => true,
     "options" => ["enctype" => "multipart/form-data"],
     ]);
    ?>
 
    <!--<? //$form->field($model, 'imageFile')->fileInput() ?>-->
    <?= $form->field($model, 'user_id')->widget(Select2::classname(),[
          'data' => ArrayHelper::map(User::find()->all(),'id',function($model){
              return $model->getUsername();
          }),
          //'data' =>ArrayHelper::map(((new StatusSearch())->search(['model' => 'backend\models\Status'])),'id','descripcion'),
          //'data' => (new StatusSearch())->search(['model' => 'backend\models\Status'])->id,
          'language' => 'es',
          'options' => ['placeholder' => 'Seleccione una persona'],
          'pluginOptions' => [
            'allowClear' => true,
          ],
        ])->label('Usuario (DNI)') ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'apellido')->textInput(['maxlength' => 45]) ?>

    <?php echo $form->field($model,'fecha_nacimiento')->
                    widget(DatePicker::className(),[
                      'dateFormat' => 'yyyy-MM-dd',
                      'clientOptions' => [
                             'yearRange' => '-115:+0',
                             'changeYear' => true]
        ]) ?>

    <?= $form->field($model, 'genero_id')->dropDownList($model->generoLista, ['prompt' => 'Por favor Seleccione Uno' ]);?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
