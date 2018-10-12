<?php
use kartik\tabs\TabsX;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use froala\froalaeditor\FroalaEditorWidget;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use backend\models\Unidad;
use backend\models\UnidadSearch;
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
