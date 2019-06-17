<?php

namespace api\modules\v1\controllers;

use Yii;
use api\modules\v1\models\Carrera;
use api\modules\v1\models\CarreraSearch;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use \yii\filters\ContentNegotiator;

/**
 * CarreraController implements the CRUD actions for Carrera model.
 */
class CarreraController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Carrera';

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
                'index' => ['GET']
            ]
        ];
        return $behaviors;
    }
    public function actionIndex(){
        $activeData = new ActiveDataProvider([
            'query' => Carrera::find(),
            'pagination' => false
        ]);
        return $activeData;
    }
}
