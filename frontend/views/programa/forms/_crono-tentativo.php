<?php
use kartik\tabs\TabsX;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use froala\froalaeditor\FroalaEditorWidget;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use common\models\Unidad;
use common\models\search\UnidadSearch;
use yii\helpers\Url;
$mensaje = [ 'onclick'=>"return confirm('No se guardarán los cambios de esta pestaña, ¿desea salir?')"];
$this->params['items'][] = ['label' => 'Portada' , 'url' => Url::to(['update', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '1. Fundamentación','url' => Url::to(['carga', 'id' => $model->id]), 'options'=>[ 'onclick'=>"return confirm('No se guardarán los cambios de esta pestaña, ¿desea salir?')"]];
$this->params['items'][] = ['label' => '2. Objetivo según plan de estudio', 'url' => Url::to(['objetivo-plan', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '3. Contenido según plan de estudio', 'url' => Url::to(['contenido-plan', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '4. Contenidos analíticos', 'url' => Url::to(['contenido-analitico', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '5. Propuesta Metodológica', 'url' => Url::to(['propuesta-metodologica', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '6. Evaluación y cond. de acreditación', 'url' => Url::to(['eval-acred', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '7. Parciales, recuperatorios y promociones', 'url' => Url::to(['parcial-rec-promo', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '8. Distribución horaria', 'url' => Url::to(['dist-horaria', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '9. Cronograma tentativo'];
$this->params['items'][] = ['label' => '10. Actividad extracurricular', 'url' => Url::to(['actividad-extracurricular', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['breadcrumbs'][] = ['label' => '...'];
$this->params['breadcrumbs'][] = ['label' => "Parciales, recuperatorios y coloquios", 'url' => ['parc-rec-promo', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => "Distribución Horaria", 'url' => ['dist-horaria', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Cronograma tentativo';
 ?>
 <div class="progress">
   <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 90%">
      90%
   </div>
 </div>
<h3>9. Cronograma Tentativo</h3>

<?= FroalaEditorWidget::widget([
            'model' => $model,
            'attribute' => 'crono_tentativo',
            'name' => 'crono_tentativo',
            'options' => [
                'id'=>'crono_tentativo'
            ],
            'clientOptions' => [
              'placeholderText' => '',
              'language' => 'es',
              'height' => 200,
              'theme' => 'gray',
              'toolbarButtons' => ['bold', 'italic', 'underline', '|','lineBreaker','paragraphFormat', 'fontSize','color','|','undo','redo','align'],
            ],
]) ?>
<br>
<div class="row">
  <div class="col-xs-6 text-left">
    <?= Html::a('Atrás', ['dist-horaria', 'id' => $model->id],['class' => 'btn btn-warning']) ?>
    <?= Html::submitButton('Guardar y salir',['class' => 'btn btn-info' , 'name'=>'submit','value' => 'salir']) ?>
  </div>
  <div class="col-xs-6 text-right">
    <?= Html::a('Seguir', ['actividad-extracurricular' , 'id' => $model->id], ['class' => 'btn btn-success']) ?>
  </div>
</div>
