<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\Carrera;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;

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
        $behaviors['corsFilter'] = [
          
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                // Permitir solo get
                'Access-Control-Request-Method' => ['GET'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Origin' => ['*'],
                'Access-Control-Allow-Credentials' => false,
                'Access-Control-Max-Age' => 3600,
                'Access-Control-Expose-Headers' => [],
            ],
        ];
        //verbo y accion
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                //'create' => ['POST'],
                //'update' => ['PUT','PATCH','POST'],
                //'delete' => ['GET'],
                'dptos' => ['GET'],
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

    public function actionDptos(){
        $activeData = new ActiveDataProvider([
            'query' => Carrera::find()->andFilterWhere(['=','departamento_id',$_GET['id']]),
            'pagination' => false
        ]);
        return $activeData;
    }
}
