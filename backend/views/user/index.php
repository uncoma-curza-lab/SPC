<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\bootstrap\Collapse;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
     <p>
        <?= Html::a('Agregar Usuario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php   echo Collapse::widget([


   'items' => [
        // equivalente a lo de arriba
        [
            'label' => 'Search',
            'content' => $this->render('_search', ['model' => $searchModel]) ,
            // open its content by default
            //'contentOptions' => ['class' => 'in']
        ],

   ]
]);


?>

   <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            ['attribute'=>'userIdLink', 'format'=>'raw'],
            ['attribute'=>'userLink', 'format'=>'raw'],
            //['attribute'=>'perfilLink', 'format'=>'raw'],

            'email:email',
            'rolNombre',
            //'tipoUsuarioNombre',
            'estadoNombre',
            [
              'attribute' => 'perfil',
              'value' => function($model){
                return $model->getPerfil()->one()->printNombre();
              }
            ],
            'created_at',

           ['class' => 'yii\grid\ActionColumn'],


            // 'updated_at',


        ],
    ]); ?>

</div>
