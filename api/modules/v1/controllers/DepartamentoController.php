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
                'index' => ['GET']
            ]
        ];
        return $behaviors;
    }
    public function actionIndex(){
        $activeData = new ActiveDataProvider([
            'query' => Departamento::find(),
            'pagination' => false
        ]);
        return $activeData;
    }

   
}
