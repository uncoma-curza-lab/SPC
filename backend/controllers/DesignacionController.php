<?php

namespace backend\controllers;

use Yii;
use backend\models\Designacion;
use backend\models\Cargo;

use backend\models\DesignacionSearch;
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionAsignar($id)
    {
      $model = new Designacion();
      $model->programa_id = $id;
      if ($model->load(Yii::$app->request->post()) && $model->save()) {
          //return $this->redirect(['programa/index', 'id' => $model->id]);
          //es el profesor adjunto?
          $se_designo = Cargo::find()->where(['=','id',$model->cargo_id])->one();
          if(isset($se_designo) && $se_designo->carga_programa == 1){
            return $this->redirect(['programa/enviar-profesor', 'id'=>$model->programa_id]);
          } else {
            //debe crear el profesor adjunto
            $this->redirect(['asignar', 'id' => $id]);
          //return $this->redirect([''])
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
        $this->findModel($id)->delete();

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
