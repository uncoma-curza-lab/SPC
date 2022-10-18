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
use Exception;
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
     * @deprecated
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
     * Puede migrarse a ProgramaController::actionVer
     * @deprecated
     */
    public function actionVer($id) {
      throw new \Exception("Deprecated method");
      $model = $this->findModel($id);
      if(Yii::$app->request->post('submit') == 'observacion' &&
          $model->load(Yii::$app->request->post()) && $model->save()) {
          return $this->redirect(['observacion/create', 'id'=>$model->id]);
      }
      return $this->render('@frontend/views/programa/info',['model' => $model]);
    }


    /**
     * Esto se va a deprecar para autoasignar a partir de resoluciones
     */
    public function actionPedir($id)
    {
      $model = $this->findModel($id);
      $model->scenario = 'pedir';
      $estadoActual = $model->getstatus()->one();
      if(!$estadoActual){
        Yii::error("Hubo problemas con el estado del programa ID:".$id,'estado-programa');

        Yii::$app->session->setFlash('danger','Programa sin estado');
        return $this->redirect(['index']);
      }

      if(!isset($model->departamento_id) && $estadoActual->descripcion == "En espera"){
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
          Yii::info("Pidió el programa:".$id." con dpto: ".$model->departamento_id,'estado-programa');

          return $this->redirect(['programa/evaluacion']);
        } else {

        }
      } else {
        Yii::error("El programa".$id." tenía departamento o no está en estado Profesor",'estado-programa');

        Yii::$app->session->setFlash('danger','Hubo un problema al pedir el programa');
        return $this->redirect(['index']);
      }
    }


    /**
     * Creates a new Generos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    //public function actionCreate()
    //{
    //    $model = new Generos();

    //    if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //        return $this->redirect(['view', 'id' => $model->id]);
    //    } else {
    //        return $this->render('create', [
    //            'model' => $model,
    //        ]);
    //    }
    //}

    /**
     * Updates an existing Generos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        throw new Exception('deprecated method]');
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
     * @deprecated
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        throw new Exception('deprecated method]');
       // $this->findModel($id)->delete();

       // return $this->redirect(['index']);
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

    /**
    * @deprecated
    * Comienzan las funciones para crear y exportar un PDF
    */
    public function actionExportPdf($id){
      return $this->redirect(['programa/export-pdf', 'id' => $id]);
    }
}
