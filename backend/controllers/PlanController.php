<?php

namespace backend\controllers;

use common\domain\Plans\CreateOrUpdatePlan\CreateOrUpdatePlanCommand;
use Yii;
use common\models\Plan;
use common\models\search\PlanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\models\Asignatura;
use common\models\PermisosHelpers;

/**
 * PlanController implements the CRUD actions for Plan model.
 */
class PlanController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
           'access' => [
                  'class' => \yii\filters\AccessControl::class,
                  'rules' => [
                      [
                           'allow' => true,
                           'roles' => ['@'],
                           'matchCallback' => function($rule,$action) {
                             return PermisosHelpers::requerirMinimoRol('Admin')
                               && PermisosHelpers::requerirEstado('Activo');
                           }
                      ],
                  ]
           ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }
    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }

    /**
     * Lists all Plan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PlanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Plan model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Plan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Plan();

        if ($model->load(Yii::$app->request->post())) {
            $createPlanCommand = new CreateOrUpdatePlanCommand(
                $model
            );
            $result = $createPlanCommand->handle();
            if ($result->getResult()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Plan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $createPlanCommand = new CreateOrUpdatePlanCommand(
                $model
            );
            $result = $createPlanCommand->handle();
            if ($result->getResult()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Plan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        //try {
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        //} catch (\yii\db\IntegrityException $e) {
        //    Yii::warning("fuck");
        //}
    }

    public function actionUpload($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->post()) {
            $model->planArchivo = UploadedFile::getInstance($model, 'planArchivo');
            if ($model->upload() && $model->save()) {
                return $this->redirect(['index']);
                // el archivo se subió exitosamente
            }
        }
        if ( $model->archivo != null || $model->archivo != "") {
            Yii::$app->session->setFlash('warning','Cuidado! ya existe un archivo cargado para este plan. Si carga un archivo será reemplazado <i class="glyphicon glyphicon-remove-sign" ></i>');
        } else {
            Yii::$app->session->setFlash('success','Aún no hay un archivo cargado para este plan. Continue cargando un archivo <i class="glyphicon glyphicon-ok-sign" ></i> ');
        }
        return $this->render('upload', ['model' => $model]);
    }

    /**
     * Copiar un plan con todas sus asignaturas
     * Esta funcion duplica las asignaturas 
     * El plan a copiar es pasado por parámetro
     * @param integer $id 
     */
    public function actionCopy($id){
        $plan = $this->findModel($id);
        $plan->planordenanza = null;
        
        $newPlan = new Plan();
        $newPlan->setAttributes($plan->attributes,false);
        $newPlan->archivo = null;
        $newPlan->id = null;

        if ($newPlan->load(Yii::$app->request->post())){
            $connection = Yii::$app->db;
            $transaction = $connection->beginTransaction();
            $transactionStatus = true;
            if ($newPlan->save(false)) 
            {
                $asignaturas = $plan->getAsignaturas()->all();
                foreach ($asignaturas as $asignatura) {
                    $newAsignatura = new Asignatura();
                    $asignatura->id = null;
                    $newAsignatura->setAttributes($asignatura->attributes,false);
                    $newAsignatura->plan_id = $newPlan->id;
                    if(! $newAsignatura->save(false) ){
                        $transactionStatus = false;
                    } 
                }
                    
            } else {
                $transactionStatus = false;
            }
            if ($transactionStatus){
                $transaction->commit();
                Yii::$app->session->setFlash('success','El plan ha sido copiado correctamente');
                return $this->redirect(['view', 'id' => $newPlan->id]);
            } else {
                $transaction->rollBack();
                Yii::$app->session->setFlash('warning','Hubo un problema al copiar el plan');
                return $this->redirect(['index']);
            }   
        }
       
        return $this->render('copy',['model' => $newPlan]);


    }

    /**
     * Finds the Plan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Plan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Plan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetPlansByCarreraId($plan_id = null, $carrera_id, $q = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $data = [];

        $query = Plan::find()->where(['carrera_id' => $carrera_id]);

        if ($plan_id) {
            $query = $query->andWhere(['!=', 'id', $plan_id]);
        }

        if (!empty($q)) {
            $query->andWhere(['like', 'planordenanza', $q]);
        }

        $models = $query->all();

        if (!empty($models)) {
            $data = array_map(function($plan) {
                return [
                    'id' => $plan->id,
                    'text' => $plan->planordenanza,
                ];
            }, $models);
        }

        return ['results' => $data];
    }


}
