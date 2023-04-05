<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\Departamento;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
/**
 * DepartamentoController implements the CRUD actions for Departamento model.
 */
class DepartamentoController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Departamento';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        //'collectionEnvelope' => 'departamentos',
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
                //'application/xml' => \yii\web\Response::FORMAT_XML,
            ],
        ];
       
        $behaviors['corsFilter'] = [
          
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                // restringir acceso a 
                'Origin' => ['*'],
                // Permitir solo get
                'Access-Control-Request-Method' => ['GET'],
                // Permitir solo cabecera 'X-Wsse'
                //'Access-Control-Request-Headers' => ['X-Request-With'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Origin' => ['*'],
                // Permitir credenciales como cookies, authorization headers, etc.
                'Access-Control-Allow-Credentials' => false,
                // Permitir cache de options
                'Access-Control-Max-Age' => 3600,
                // Permitir cabecera X-Pagination-Current-Page. Que explorador es permitido?
                //'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
                'Access-Control-Expose-Headers' => [],
            ],
            /*'actions' => [
                'index' => [
                    'Access-Control-Allow-Credentials' => true
                ]
            ]*/
        ];
        /*$behaviors['authenticator'] = [
            'class' => \yii\filters\auth\HttpBasicAuth::class
        ];*/
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

    public function actionIndex()
    {
        $query = Departamento::find();
        $activeData = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);
        return $activeData;
    }

    public function actionCarrera()
    {
        $query = Departamento::find()->getCarreras()->all();
        $activeData = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);
        return $activeData;
    }

   
}
