<?php

namespace frontend\controllers;

use Yii;
use common\models\Observacion;
use common\events\NotificationEvent;
use common\models\Programa;
use common\models\search\ObservacionSearch;
use common\models\EventType;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ObservacionController implements the CRUD actions for Observacion model.
 */
class ObservacionController extends Controller
{
    const CREAR_OBSERVACION = "crear-observacion";
    
    public function init() {
        parent::init();
    }

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
     * Lists all Observacion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ObservacionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Observacion model.
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
     * Creates a new Observacion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Observacion();
        $model->programa_id = $id;

        if ($model->load(Yii::$app->request->post())) {
          if($model->save()){
            Yii::$app->session->setFlash('success','Observación agregada exitosamente');
            //generar notificacion
            $userInitID = \Yii::$app->user->identity->id;
            $userReceiverID = Programa::findOne($id)->created_by;
            $notificar = new NotificationEvent(self::CREAR_OBSERVACION,$userInitID ,$userReceiverID,$id);
            $this->on(self::CREAR_OBSERVACION,[$notificar,'notificar']); 
            $this->trigger(self::CREAR_OBSERVACION,$notificar);
            return $this->redirect(['generales/ver', 'id' => $model->programa_id]);
          } else {
            Yii::$app->session->setFlash('danger','Observación no agregada');
          }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Observacion model.
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
     * Deletes an existing Observacion model.
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
     * Finds the Observacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Observacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Observacion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    
}
