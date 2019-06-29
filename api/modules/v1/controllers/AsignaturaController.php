<?php
namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use api\modules\v1\models\Asignatura;
use yii\filters\auth\HttpBasicAuth;
use \yii\filters\ContentNegotiator;
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
        /*return [
            [
                'class' => \yii\filters\ContentNegotiator::className(),
                'formats' => [
                    'application/json' => ,
                ],
            ],
        ];*/
        return $behaviors;
    }
    /*public function actions() {
        $actions = parent::actions();
        return array_merge($actions,[
            'index' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'prepareDataProvider' => function ($action) {
                    $model = new $this->modelClass;
                    $query = $model::find();
                    $dataProvider = new ActiveDataProvider(['query' => $query]);
                    $model->setAttribute('nomenclatura', @$_GET['nomenclatura']);
                    $query->andFilterWhere(['like', 'nomenclatura', $model->nomenclatura]);
                    return $dataProvider;
                }
            ]
        ]);
        //unset($actions['index']);
        //return $actions;
    }
    */
    /*protected function verbs(){
        return [];
    }*/
    public function actionIndex(){
        $activeData = new ActiveDataProvider([
            'query' => Asignatura::find(),
            'pagination' => false
        ]);
        return $activeData;
    }
    
    /**
     * crear Asignatura
     *
     * @return Asignatura
     * @throws HttpException
     * @throws \yii\base\InvalidConfigException
     */
    /*
    public function actionCreate()
    {
        $model = new Asignatura();
        $bodyParam = \Yii::$app->getRequest()->getBodyParams();
        if (isset($bodyParam['meta_key'])) {
            $bodyParam['meta_key'] = strtolower($bodyParam['meta_key']);
        }
        $model->load($bodyParam, '');
        if ($model->validate() && $model->save()) {
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute([$id], true));
        } else {
            //  error en validacion
            throw new HttpException(422, json_encode($model->errors));
        }
        return $model;
    }
    */
    public function actionAsignaturas(){
        $activeData = new ActiveDataProvider([
            'query' => Asignatura::find()->andFilterWhere(['=','plan_id',$_GET['id']]),
            'pagination' => false
        ]);
        return $activeData;
    }
}