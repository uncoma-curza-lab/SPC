<?php
namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use api\modules\v1\models\Asignatura;
use api\modules\v1\models\Plan;
use yii\data\ArrayDataProvider;

class AsignaturaController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Asignatura';
    
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        //'collectionEnvelope' => 'asignaturas',
    ];
    public function behaviors() {
        $behaviors = parent::behaviors();
        //$behaviors['authenticator'] = [
        //    'class' => HttpBasicAuth::className(),
        //];
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
        $behaviors['contentNegotiator'] = [
            'class' => \yii\filters\ContentNegotiator::className(),
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
            ],
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                //'create' => ['POST'],
                //'update' => ['PUT','PATCH','POST'],
                //'delete' => ['GET'],
                'index' => ['GET'],
                'asignaturas' => ['GET']
            ]
        ];
        return $behaviors;
    }

    public function actionIndex(){
        $activeData = new ActiveDataProvider([
            'query' => Asignatura::find(),
            'pagination' => false
        ]);
        return $activeData;
    }
    public function actionAsignaturas()
    {
        if ($planId = $_GET['id']) {
            $plan = Plan::findOne($planId);
            if ($plan) {
                $asignatura = $plan->getCoursesTreeFromRoot();
                return new ArrayDataProvider([
                    'allModels' => $asignatura,
                    'pagination' => false,
                ]);
            }
        }

        $activeData = new ActiveDataProvider([
            'query' => Asignatura::find()->andFilterWhere(['=','plan_id',$_GET['id']]),
            'pagination' => false
        ]);
        return $activeData;
    }
}
