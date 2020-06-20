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
                       'actions' => ['index', 'view','create', 'update', 'delete'],
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
     * Listado de todos los programas publicados y en circulación
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

    /**
     * Se reemplaza la visualización de programas.
     * Puede que esta funcion ya no se utilice
     * @param integer $id
     */
    public function actionVer($id) {
      $model = $this->findModel($id);
      if(Yii::$app->request->post('submit') == 'observacion' &&
          $model->load(Yii::$app->request->post()) && $model->save()) {
          return $this->redirect(['observacion/create', 'id'=>$model->id]);
      }
      return $this->render('info',['model' => $model]);
    }

    /**
     * Permite a un director solicitar el programa
     * Esto se hace ya que no es posible saber qué asignaturas evalua cada departamento
     * @Update se debería usar la ordenanza de estructura departamental, se consiguió la misma Julio de 2020
     */
    public function actionPedir($id){
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
     * Busca un programa
     * Si no lo encuentra, entonces lo emite una excepción.
     * @param integer $id
     * @return Programa the loaded model
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
