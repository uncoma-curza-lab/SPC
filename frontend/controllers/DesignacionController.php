<?php

namespace frontend\controllers;

use Yii;
use common\models\Designacion;
use common\models\Cargo;
use common\models\PermisosHelpers;
use common\models\search\DesignacionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
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
           'access' => [
                  'class' => \yii\filters\AccessControl::className(),

                  'rules' => [
                      [
                           'actions' => [
                             'index',
                             'create',
                           ],
                           'allow' => true,
                           'roles' => ['@'],
                           'matchCallback' => function($rule,$action) {
                             return PermisosHelpers::requerirMinimoRol('Admin')
                               && PermisosHelpers::requerirEstado('Activo');
                           }
                      ],
                      [
                           'actions' => [
                             'asignar', 'view','delete','update',
                           ],
                           'allow' => true,
                           'roles' => ['@'],
                           'matchCallback' => function($rule,$action) {
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
      $esDirector = PermisosHelpers::requerirDirector($id);
      if($esDirector){
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
      throw new ForbiddenHttpException('Usted no tiene permisos para esto');
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
        $programa = $model->getPrograma()->one()->getStatus()->one();


        if(PermisosHelpers::requerirDirector($model->programa_id) && $programa->descripcion == "Borrador"){
          $model->delete();
          Yii::$app->session->setFlash('success','Se borró exitosamente');
        } else {
          Yii::$app->session->setFlash('danger','No puede borrar este cargo');
        }


        return $this->redirect(['programa/index']);
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
      $esusuario = PermisosHelpers::requerirMinimoRol('Profesor');
      $userId = \Yii::$app->user->identity->id;

        if (($model = Designacion::findOne($id)) !== null) {
          if($esusuario)
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
