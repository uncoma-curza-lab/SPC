<?php

namespace frontend\controllers;

use Yii;
use common\models\NotificationPanel;
use frontend\models\search\NotificationUserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\PermisosHelpers;

/**
 * RolController implements the CRUD actions for Rol model.
 */
class UserNotificationsController extends Controller
{
    public function behaviors()
    {
       return [
            
        'access' => [
               'class' => \yii\filters\AccessControl::className(),
               'only' => ['index','ver','update','delete','view','create'],
               'rules' => [
                   [
                       'actions' => ['index','ver'],
                       'allow' => true,
                       'roles' => ['@'],
                       'matchCallback' => function ($rule, $action) {
                        return  PermisosHelpers::requerirEstado('Activo');
                       }
                   ],
                    [
                       'actions' => [ 'update', 'delete', 'view','create', 'update', 'delete'],
                       'allow' => true,
                       'roles' => ['@'],
                       'matchCallback' => function ($rule, $action) {
                        return PermisosHelpers::requerirMinimoRol('SuperUsuario') 
                        && PermisosHelpers::requerirEstado('Activo');
                       }
                   ],
                        
               ],
                    
           ],
      
          'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['post'],
                    ],
                ],
            ];
    }
    
    /**
     * Lists all Rol models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NotificationUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Rol model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Rol model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new NotificationPanel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Rol model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Rol model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionVer($id,$notif_id){
        // id programa_id
        //$url = Url::to(['mi-programa/ver','id' => $id]);
        $notification = NotificationPanel::findOne($notif_id);
        $notification->setRead();
        $notification->save(false);

        $this->redirect(['programa/ver','id' => $id]);

    }
    public function actionAllRead(){
        if(!Yii::$app->user->isGuest){
            $userID = Yii::$app->user->id;
            $notificaciones = NotificationPanel::find()->filterWhere(['=','type',NotificationPanel::DISCR])->andWhere(['read' => NULL])->all();
            foreach ($notificaciones as $notificacion) {
                $notificacion->setRead();
                $notificacion->save(false);
            }
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Rol model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Rol the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserNotificationController::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    
}
