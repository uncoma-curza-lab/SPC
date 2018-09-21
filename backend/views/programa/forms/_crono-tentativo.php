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

<h3>9. Cronograma Tentativo</h3>

<?= GridView::widget([
    'dataProvider' => new ActiveDataProvider([
      'query' => $model->getUnidades()
    ]),
    'filterModel' => new UnidadSearch(),
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
          'attribute' => 'descripcion',
          'format' => 'html',
          'value' => function($data){
            if(strlen($data->descripcion) > 40){
              return substr($data->descripcion,0,50)."...";
            } else {
              return $data->descripcion;
            }
          }
        ],
        'crono_tent',

        [
          'class' => 'yii\grid\ActionColumn',
          'controller' => 'unidad'
        ],
    ],
]); ?>
<p>
    <?= Html::a('Seguir', ['actividad-extracurricular' , 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    <?= Html::a('Volver', ['dist-horaria', 'id' => $model->id],['class' => 'btn btn-warning']) ?>
</p>
