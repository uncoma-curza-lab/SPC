<?php

namespace frontend\controllers;

use Yii;
use common\models\Objetivo;
use common\models\search\ObjetivoSearch;
use Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * @deprecated
 * ObjetivoController implements the CRUD actions for Objetivo model.
 */
class ObjetivoController extends Controller
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
     * Lists all Objetivo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ObjetivoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Objetivo model.
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
     * Creates a new Objetivo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        throw new Exception('Deprecated module');
        $model = new Objetivo();
        $model->programa_id=$id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['programa/objetivo-plan', 'id' =>$id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Objetivo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        throw new Exception('Deprecated module');
        $model = new Objetivo();
        $model->programa_id=$id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['programa/objetivo-plan', 'id' =>$id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * 
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['programa/objetivo-plan', 'id' => $model->programa_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Objetivo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $programa_id = $model->programa_id;
        $this->findModel($id)->delete();

        return $this->redirect(['programa/objetivo-plan','id'=>$programa_id]);
    }

    /**
     * Finds the Objetivo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Objetivo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Objetivo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
