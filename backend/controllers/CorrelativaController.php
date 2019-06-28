<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\PermisosHelpers;
use common\models\EstadoHelpers;
use common\models\Correlativa;
use common\models\search\CorrelativaSearch;
use common\models\Asignatura;

/**
 * CarreraProgramaController implements the CRUD actions for CarreraPrograma model.
 */
class CorrelativaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
          'access' => [
                 'class' => \yii\filters\AccessControl::className(),
                 'only' => ['index', 'view','create', 'update', 'delete'],
                 'rules' => [
                     [
                         'actions' => ['index', 'view',],
                         'allow' => true,
                         'roles' => ['@'],
                         'matchCallback' => function ($rule, $action) {
                          return PermisosHelpers::requerirMinimoRol('Usuario')
                          && PermisosHelpers::requerirEstado('Activo');
                         }
                     ],
                      [
                         'actions' => [ 'create', 'update', 'delete'],
                         'allow' => true,
                         'roles' => ['@'],
                         'matchCallback' => function ($rule, $action) {
                          return PermisosHelpers::requerirMinimoRol('Profesor')
                          && PermisosHelpers::requerirEstado('Activo');
                         }
                     ],
                 ],
             ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all CarreraPrograma models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CorrelativaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CarreraPrograma model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($asignatura_id,$correlativa_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($asignatura_id,$correlativa_id),
        ]);
    }

    /**
     * Creates a new CarreraPrograma model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Correlativa();
        //$model->programa_id=$id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['correlativa/update', 'id' => $model->asignatura_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CarreraPrograma model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($asignatura_id,$correlativa_id)
    {
        $model = $this->findModel($asignatura_id,$correlativa_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['correlativa/update', 
            'asignatura_id' => $model->correlativa_id , 'correlativa_id' => $model->correlativa_id ]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    
    /**
     * Deletes an existing CarreraPrograma model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CarreraPrograma model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CarreraPrograma the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($asign_id,$correl_id)
    {
        if (($model = Correlativa::find()->where(['=','asignatura_id',$asign_id])->andWhere(['=','correlativa_id',$correl_id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
