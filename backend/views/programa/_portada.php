<?php
  use yii\helpers\Html;
  use yii\widgets\ActiveForm;
  use kartik\select2\Select2;
  use yii\helpers\ArrayHelper;
  use unclead\multipleinput\MultipleInput;
  use backend\models\Carrera;
  use yii\widgets\Pjax;
  use yii\data\ActiveDataProvider;
  use common\models\PermisosHelpers;
  use common\models\EstadoHelpers;
  use backend\models\Status;
  use backend\models\StatusSearch;
  use yii\helpers\Url;

  function filtrarEstados($model){
    $esAdmin = PermisosHelpers::requerirMinimoRol('Admin');
    $userId = \Yii::$app->user->identity->id;
    $query = Status::find();
    if(!$esAdmin){
     if(PermisosHelpers::requerirRol('Profesor')) {
        //obtiene el peso de departamnto
        $status = EstadoHelpers::getValue('Departamento');
      } else if(PermisosHelpers::requerirRol('Departamento')) {
        //obtiene el peso de adm academica
        $status = EstadoHelpers::getValue('Administración Académica');
      } else if(PermisosHelpers::requerirRol('Adm_academica')) {
        //obtiene el peso de sec academica
        $status = EstadoHelpers::getValue('Secretaría Académica');
      } else if(PermisosHelpers::requerirRol('Sec_academica')) {
        //obtiene el peso de biblioteca
        $status = EstadoHelpers::getValue('Biblioteca');
      } else {
        $status = 0;
      }
      if (!isset($model->id)) {
        $status = EstadoHelpers::getValue('Borrador');
      }

      $query->andFilterWhere(['<=','value' ,$status]);
    }
    return ArrayHelper::map($query->all(),'id','descripcion');

  }

  if (isset($model->id)){
    $mensaje = [ 'onclick'=>"return confirm('No se guardarán los cambios de esta pestaña, ¿desea salir?')"];
    $this->params['items'][] = ['label' => 'Portada' ];
    $this->params['items'][] = ['label' => '1. Fundamentación','url' => Url::to(['fundamentacion', 'id' => $model->id]), 'options'=>[ 'onclick'=>"return confirm('No se guardarán los cambios de esta pestaña, ¿desea salir?')"]];
    $this->params['items'][] = ['label' => '2. Objetivo según plan de estudio', 'url' => Url::to(['objetivo-plan', 'id' => $model->id]), 'options'=> $mensaje];
    $this->params['items'][] = ['label' => '3. Contenido según plan de estudio', 'url' => Url::to(['contenido-plan', 'id' => $model->id]), 'options'=> $mensaje];
    $this->params['items'][] = ['label' => '4. Contenidos analíticos', 'url' => Url::to(['contenido-analitico', 'id' => $model->id]), 'options'=> $mensaje];
    $this->params['items'][] = ['label' => '5. Propuesta Metodológica', 'url' => Url::to(['propuesta-metodologica', 'id' => $model->id]), 'options'=> $mensaje];
    $this->params['items'][] = ['label' => '6. Evaluación y cond. de acreditación', 'url' => Url::to(['eval-acred', 'id' => $model->id]), 'options'=> $mensaje];
    $this->params['items'][] = ['label' => '7. Parciales, recuperatorios y promociones', 'url' => Url::to(['parcial-rec-promo', 'id' => $model->id]), 'options'=> $mensaje];
    $this->params['items'][] = ['label' => '8. Distribución horaria', 'url' => Url::to(['dist-horaria', 'id' => $model->id]), 'options'=> $mensaje];
    $this->params['items'][] = ['label' => '9. Cronograma tentativo', 'url' => Url::to(['crono-tentativo', 'id' => $model->id]), 'options'=> $mensaje];
    $this->params['items'][] = ['label' => '10. Actividad extracurricular', 'url' => Url::to(['actividad-extracurricular', 'id' => $model->id]), 'options'=> $mensaje];
  }
?>

<br>
<div class="progress">
  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width: 1%">
     1%
  </div>
</div>
<?php Pjax::begin(); ?>

<?php $form = ActiveForm::begin([
  'enableAjaxValidation'      => false,
  'enableClientValidation'    => false,
  'validateOnChange'          => true,
  'validateOnSubmit'          => false,
  'validateOnBlur'            => false,
]); ?>


<div class="row">
  <div class="col-xs-6">
    <?= $form->field($model, 'asignatura')->textInput(['maxlength' => true]) ?>
  </div>
  <!-- <div class="col-xs-4">
    <?= $form->field($model, 'status_id')->widget(Select2::classname(),[
        'data' => filtrarEstados($model),
        //'data' =>ArrayHelper::map(((new StatusSearch())->search(['model' => 'backend\models\Status'])),'id','descripcion'),
        //'data' => (new StatusSearch())->search(['model' => 'backend\models\Status'])->id,

        'language' => 'es',
        'options' => ['placeholder' => 'Seleccione un estado'],
        'pluginOptions' => [
          'allowClear' => true,
        ],
      ]) ?>
  </div>-->

  <div class="col-xs-2">
    <?= $form->field($model, 'year')->textInput(['maxlength' => true, 'placeholder'=> 2018]) ?>
  </div>
</div>

<div class="row">
  <div class="col-xs-2">
    <?= $form->field($model, 'cuatrimestre')->widget(Select2::classname(),[
        'data' => [1=>'1',2=>'2'],
        'language' => 'es',
        'options' => ['placeholder' => 'Seleccione un CUATRIMESTRE'],
        'pluginOptions' => [
          'allowClear' => true,
        ],
      ]) ?>
  </div>
  <div class="col-xs-4">
    <?= $form->field($model, 'curso')->textInput(['maxlength' => true]) ?>
  </div>

</div>



<div class="row">
  <div class="col-xs-6">
    <!--<?// $form->field($model, 'profadj_regular')->textInput(['maxlength' => true]) ?>-->
  </div>
  <div class="col-xs-6">
    <!--<?// $form->field($model, 'asist_regular')->textInput(['maxlength' => true]) ?>-->
  </div>
</div>
<div class="row">
  <div class="col-xs-6">
    <!--<?// $form->field($model, 'ayudante_p')->textInput(['maxlength' => true]) ?>-->
<!--    <?// $form->field($model, 'ayudante_p')->widget(MultipleInput::Classname(),
      [
        'name' => 'ayudante_p',
      ]) ?>-->
  </div>
  <div class="col-xs-6">
    <!--<?// $form->field($model, 'ayudante_s')->textInput(['maxlength' => true]) ?>-->
  </div>
</div>


<div class="form-group">
    <div class="row">
      <div class="col-xs-6 text-left">
        <?= Html::a('Salir', ['index'],['class' => 'btn btn-warning']) ?>
        <?= Html::submitButton('Guardar y salir',['class' => 'btn btn-info' , 'name'=>'submit','value' => 'salir']) ?>
      </div>
      <div class="col-xs-6 text-right">
        <?= Html::submitButton('Seguir', ['class' => 'btn btn-success']) ?>
      </div>
    </div>
</div>
<hr>

<h2> Cargos </h2>
<div class="row">
  <?= $this->render('forms/_gridCargos',['model' => $model]) ?>
</div>

<hr>
<h2> Carreras </h2>
<div class="row">
  <?= $this->render('forms/_gridCarreras',['model' => $model]) ?>
</div>
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
