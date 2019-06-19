<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use api\modules\v1\models\Departamento;
use api\modules\v1\models\search\DepartamentoSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use \yii\filters\ContentNegotiator;
/**
 * DepartamentoController implements the CRUD actions for Departamento model.
 */
class DepartamentoController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Departamento';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'departamentos',
        'expandParam' => 'carreras'
    ];
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        //Formato
        $behaviors['contentNegotiator'] = [
            'class' => \yii\filters\ContentNegotiator::className(),
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
            ],
        ];
        //verbo y accion
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                //'create' => ['POST'],
                //'update' => ['PUT','PATCH','POST'],
                //'delete' => ['GET'],
                'index' => ['GET'],
                'carrera' => ['GET']
            ]
        ];
        return $behaviors;
    }
    public function actions(){
        $actions = parent::actions();
       
        unset($actions['index']);
        
        return $actions;
    }
    public function actionIndex(){
        $query = Departamento::find();
        //if ($_GET['carrera']){
        //    query = $query->andFilterWhere('')
        //}
        $activeData = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);
        return $activeData;
    }
    public function actionCarrera(){
        $query = Departamento::find()->all()->getCarreras()->all();
        $activeData = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);
        return $activeData;
    }

   
}
