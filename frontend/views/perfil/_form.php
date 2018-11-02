<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\typeahead\TypeaheadBasic;
use frontend\models\Perfil;


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
    <figure>
       <?= $photo ?>
    </figure>
    <!--<? //$form->field($model, 'imageFile')->fileInput() ?>-->

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'apellido')->textInput(['maxlength' => 45]) ?>

  <!--  <? // $form->field($model, 'localidad')->textInput(['maxlength' => 255])->widget(TypeaheadBasic::classname(), ['data'=>$localidadesData])
    ?> -->

    <!--<? //$form->field($model, 'telefono')->textInput(['maxlength' => 255]) ?>-->

  <!--  <? //$form->field($model, 'cargo')->textInput(['maxlength' => 255])
            ->widget(TypeaheadBasic::classname(), ['data'=>$cargosData])
    ?> -->

    <?php echo $form->field($model,'fecha_nacimiento')->
                    widget(DatePicker::className(),[
                      'dateFormat' => 'yyyy-MM-dd',
                      'clientOptions' => [
                             'yearRange' => '-115:+0',
                             'changeYear' => true]
        ]) ?>

    <?= $form->field($model, 'genero_id')->dropDownList($model->generoLista, ['prompt' => 'Por favor Seleccione Uno' ]);?>
<?= $form->field($model, 'departamento_id')->dropDownList($model->departamentoLista, ['prompt' => 'Por favor Seleccione Uno' ]);?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
