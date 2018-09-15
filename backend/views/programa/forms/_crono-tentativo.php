<?php
use kartik\tabs\TabsX;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use froala\froalaeditor\FroalaEditorWidget;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use backend\models\Unidad;
use backend\models\UnidadSearch;
 ?>

<h3>10. Cronograma Tentativo</h3>
<?= GridView::widget([
    'dataProvider' => new ActiveDataProvider([
      'query' => $model->getUnidades()
    ]),
    'filterModel' => new UnidadSearch(),
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'descripcion',
        'crono_tent',

        [
          'class' => 'yii\grid\ActionColumn',
          'controller' => 'unidad'
        ],
    ],
]); ?>
<p>
    <?= Html::a('Guardar', ['actividad-extracurricular' , 'id' => $model->id], ['class' => 'btn btn-success']) ?>
</p>
