<?php

namespace backend\controllers;

use Yii;
use common\models\Designacion;
use common\models\Departamento;

use common\models\Cargo;
use common\models\PermisosHelpers;
use common\models\search\DesignacionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DesignacionController implements the CRUD actions for Designacion model.
 */
class DesignacionController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Designacion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DesignacionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Designacion model.
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
     * Creates a new Designacion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     public function actionCreate()
     {
         $model = new Designacion();

         if ($model->load(Yii::$app->request->post()) ) {
           $transaction = Yii::$app->db->beginTransaction();
           try {
             if($model->save(false)){
               if ($model->departamento_id != null) {
                 $depto = Departamento::findOne($model->departamento_id);
                 $depto->director = $model->id;
                 if ($depto->save(false)){
                   Yii::$app->session->setFlash('success','Designación agregada correctamente');

                   $transaction->commit();
                   return $this->redirect(['view', 'id' => $model->id]);
                 }
               }
             }
             Yii::$app->session->setFlash('warning','Hubo un problema al agregar la designación');

             $transaction->rollBack();
             return $this->redirect(['index']);
           }catch (\Exception $e) {
               $transaction->rollBack();
               throw $e;
           }
         }

         return $this->render('create', [
             'model' => $model,
         ]);
     }

    public function actionAsignar($id)
    {
      $model = new Designacion();
      $model->programa_id = $id;

      if ($model->load(Yii::$app->request->post())) {
          $cargoProfAdj = Cargo::find()->where(['=','carga_programa',1])->one();
          if ($cargoProfAdj->id == $model->cargo_id && PermisosHelpers::existeProfAdjunto($id)){
            throw new NotFoundHttpException('Ya existe un Profesor Adjunto');
          }
          if ($model->save()){
            Yii::$app->session->setFlash('success','Se asignó el cargo exitosamente');
            $this->redirect(['programa/index', 'id' => $id]);
          } else {
            Yii::$app->session->setFlash('warning','Hubo un problema al asignar el cargo');
            $this->redirect(['asignar', 'id' => $id]);
          }
      }

      return $this->render('asignar', [
          'model' => $model,
      ]);
    }

    /**
     * Updates an existing Designacion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Designacion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $depto = $model->getDepartamento()->one();
        $depto->director = null;
        if ($depto->save() && $model->delete())
          return $this->redirect(['index']);
    }

    /**
     * Finds the Designacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Designacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Designacion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
