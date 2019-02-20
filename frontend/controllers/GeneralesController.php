<?php

namespace frontend\controllers;

use Yii;
use common\models\Programa;
use common\models\Cargo;
use common\models\Designacion;
use common\models\search\GeneralesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\PermisosHelpers;
use common\models\Status;
use Mpdf;

/**
 * GenerosController implements the CRUD actions for Generos model.
 */
class GeneralesController extends Controller
{
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
                        return PermisosHelpers::requerirMinimoRol('Usuario')
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
     * Lists all Generos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GeneralesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDeptos(){
      return $this->render('deptos/portal');
    }

    public function actionEditar($id)
    {
        if(PermisosHelpers::requerirDirector($id)){
          $model = $this->findModel($id);
          $searchModel = new GeneralesSearch();
          $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
          if ($model->load(Yii::$app->request->post()) && $model->save()) {
              return $this->redirect(['index', 'id' => $model->id]);
          }

          return $this->render('editar', [
            'model' => $model,
            'searchModel' => $searchModel
          ]);
        } else {
            Yii::$app->session->setFlash('danger','Usted no puede editar este programa');
            return $this->redirect(['index']);
        }
    }

    /**
     * Displays a single Generos model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionVer($id) {
      $model = $this->findModel($id);
      if(Yii::$app->request->post('submit') == 'observacion' &&
          $model->load(Yii::$app->request->post()) && $model->save()) {
          return $this->redirect(['observacion/create', 'id'=>$model->id]);
      }
      return $this->render('info',['model' => $model]);
    }


    public function actionPedir($id){
      $model = $this->findModel($id);
      $model->scenario = 'pedir';
      $estadoActual = $model->getstatus()->one();
      if(!$estadoActual){
        Yii::$app->session->setFlash('danger','Programa sin estado');
        return $this->redirect(['index']);
      }

      if(!isset($model->departamento_id) && $estadoActual->descripcion == "Profesor"){
        $perfil = \Yii::$app->user->identity->perfil;
        // si es director tiene una designación con ese cargo
        $cargoDirector = Cargo::find()->where(['=','nomenclatura','Director'])->one();
        $designacion = Designacion::find()->where(['=','perfil_id',$perfil->id])->andWhere(['=','cargo_id',$cargoDirector->id])->one();
        if($designacion){
          $model->departamento_id = $designacion->departamento_id;
          $estadoSiguiente = Status::find()->where(['>','value',$estadoActual->value])->orderBy('value')->one();
          $model->status_id = $estadoSiguiente->id;
        } else {
          Yii::$app->session->setFlash('danger','No tiene un cargo directivo');
          return $this->redirect(['index']);
        }
        if ($model->save()){
          return $this->redirect(['programa/departamento']);
        } else {

        }
      } else {
        Yii::$app->session->setFlash('danger','Hubo un problema al pedir el programa');
        return $this->redirect(['index']);
      }
    }
    public function actionAprobar($id){
        $programa = $this->findModel($id);
        $programa->scenario = 'carrerap';
        $userId = \Yii::$app->user->identity->id;
        $estadoActual = Status::findOne($programa->status_id);

        if ($estadoActual->descripcion == "Borrador"){
          if($programa->calcularPorcentajeCarga() < 40) {
            Yii::$app->session->setFlash('danger','Debe completar el programa un 40%');
            return $this->redirect(['cargar','id' => $programa->id]);
          } else if ($programa->created_by == $userId){
            if ($programa->subirEstado() && $programa->save()) {
              Yii::$app->session->setFlash('success','Se confirmó el programa exitosamente');
            } else {
              Yii::$app->session->setFlash('danger','Hubo un problema al confirmar el programa');
            }
            return $this->redirect(['index']);
          }
        }
       if (PermisosHelpers::requerirRol("Departamento")
        && $estadoActual->descripcion == "Profesor"
        && $programa->created_by != $userId ){
          Yii::$app->session->setFlash('danger','Debe pedir el programa antes de seguir');
          return $this->redirect(['index']);
       }
       if( (PermisosHelpers::requerirDirector($id) && ($estadoActual->descripcion == "Departamento")) ||
          (PermisosHelpers::requerirRol("Adm_academica") && $estadoActual->descripcion == "Administración Académica") ||
          (PermisosHelpers::requerirRol("Sec_academica") && $estadoActual->descripcion == "Secretaría Académica")
        ){
          if($programa->subirEstado() && $programa->save()){
            Yii::$app->session->setFlash('success','Se confirmó el programa exitosamente');
            return $this->redirect(['index']);
          } else {
            Yii::$app->session->setFlash('danger','Hubo un problema al intentar aprobar el programa');
            return $this->redirect(['index']);

//            throw new NotFoundHttpException("Ocurrió un error");
          }
        }
    }

    public function actionRechazar($id){
        $programa = $this->findModel($id);
        $programa->scenario = 'carrerap';
        $userId = \Yii::$app->user->identity->id;
        $estadoActual = Status::findOne($programa->status_id);

        if ($estadoActual->descripcion == "Borrador" || $estadoActual->descripcion == "Profesor"){
          Yii::$app->session->setFlash('danger','Hubo un problema al intentar rechazar el programa');
          return $this->redirect(['index']);
        }
        if(PermisosHelpers::requerirDirector($id) && $estadoActual->descripcion == "Departamento"){
            if ($programa->setEstado("Borrador") && $programa->save()){
              Yii::$app->session->setFlash('warning','Se rechazó el programa correctamente');
              return $this->redirect(['index']);
            } else {
              Yii::$app->session->setFlash('danger','Hubo un problema al rechazar el programa');
              return $this->redirect(['index']);
            }
        }

        if((PermisosHelpers::requerirRol("Adm_academica") && $estadoActual->descripcion == "Administración Académica") ||
          (PermisosHelpers::requerirRol("Sec_academica") && $estadoActual->descripcion == "Secretaría Académica")
        ){
          //$programa->status_id = Status::findOne(['descripcion','=','Departamento'])->id;

          if($programa->bajarEstado() &&  $programa->save()){
            Yii::$app->session->setFlash('warning','Se rechazó el programa correctamente');
            return $this->redirect(['index']);
          } else {
            Yii::$app->session->setFlash('danger','Hubo un problema al rechazar el programa');
            return $this->redirect(['index']);
          }
        }
    }

    /**
     * Creates a new Generos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Generos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Generos model.
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
     * Deletes an existing Generos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Generos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Generos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Programa::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*
    * Comienzan las funciones para crear y exportar un PDF
    */
    public function actionExportPdf($id){
      return $this->redirect(['programa/export-pdf', 'id' => $id]);
    }
}
