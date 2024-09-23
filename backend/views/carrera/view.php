<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

$carreraModalidades = new ActiveDataProvider([
    'query' => $model->getModalidades(),
    'pagination' => [
        'pagesize' => 20,
    ]
]);

/* @var $this yii\web\View */
/* @var $model backend\models\Carrera */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Carreras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carrera-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nom',
            'codigo',
            [
                'attribute' => 'departamento_id',
                'value' => function ($model){
                    $depto = $model->getDepartamento()->one();
                    return $depto ? $depto->getNomenclatura() : "Sin departamento";
                }
            ],
            [
                'attribute' => 'nivel_id',
                'value' => function ($model){
                    $depto = $model->getNivel()->one();
                    return $depto ? $depto->getDescripcion() : "Sin nivel";
                }
            ],
            [
                'attribute' => 'plan_vigente_id',
                'value' => function($model){
                    $plan = $model->getPlanVigente()->one();
                    return $plan ? $plan->getOrdenanza() : "N/N/";
                }
            ],
           [
                'attribute' => 'related_files',
                'label' => 'Brochure',
                'format' => 'html',
                'value' => function($model) {
                    $urls = $model->getUrlToRelatedFiles();
                    if (isset($urls['brochure'])) {
                        $url = $urls["brochure"];
                        $extension = pathinfo($url, PATHINFO_EXTENSION);

                        if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif'])) {
                            return Html::img($url, [
                                'alt' => 'folleto',
                                'style' => 'width:200px;'
                            ]);
                        } else {
                            return Html::a('Descargar archivo', $url, ['target' => '_blank']);
                        }
                    }
                    return "No hay archivo disponible";
                }
            ],
        ],
    ]) ?>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => $carreraModalidades,
    ]) ?>



</div>
