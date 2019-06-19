<?php

namespace api\modules\v1\controllers;

use Yii;
use api\modules\v1\models\Plan;
use api\modules\v1\models\search\PlanSearch;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;


/**
 * PlanController implements the CRUD actions for Plan model.
 */
class PlanController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Plan';

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
                'carreras' => ['GET']
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
        
        $activeData = new ActiveDataProvider([
            //'query' => Plan::find()->andFilterWhere(['=','id',$_GET['dpto']]),
            'query' => Plan::find(),
            'pagination' => false
        ]);
        return $activeData;
    }
    public function actionCarreras(){
        $activeData = new ActiveDataProvider([
            'query' => Plan::find()->andFilterWhere(['=','carrera_id',$_GET['id']]),
            'pagination' => false
        ]);
        return $activeData;
    }
}
