<?php

namespace frontend\controllers;

use Yii;
use common\models\Programa;
use common\models\search\GeneralesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\PermisosHelpers;
use common\models\Status;

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
    public function actionAprobar($id){
        $programa = $this->findModel($id);
        $programa->scenario = 'carrerap';
        $userId = \Yii::$app->user->identity->id;
        $estadoActual = Status::findOne($programa->status_id);
        if((PermisosHelpers::requerirProfesorAdjunto($id) && $estadoActual->descripcion == "Profesor") && $programa->calcularPorcentajeCarga() < 40){
              Yii::$app->session->setFlash('danger','Debe completar el programa un 30%');
              return $this->redirect(['cargar','id' => $programa->id]);
        } else if((PermisosHelpers::requerirProfesorAdjunto($id) && $estadoActual->descripcion == "Profesor")||
          (PermisosHelpers::requerirDirector($id) && ($estadoActual->descripcion == "Departamento" || $estadoActual->descripcion == "Borrador")) ||
          (PermisosHelpers::requerirRol("Adm_academica") && $estadoActual->descripcion == "Administración Académica") ||
          (PermisosHelpers::requerirRol("Sec_academica") && $estadoActual->descripcion == "Secretaría Académica")
        ){
          //$programa->status_id = Status::findOne(['descripcion','=','Departamento'])->id;

          $estadoSiguiente = Status::find()->where(['>','value',$estadoActual->value])->orderBy('value')->one();
          $programa->status_id = $estadoSiguiente->id;
          if( $programa->save()){
            Yii::$app->session->setFlash('success','Se confirmó el programa exitosamente');
            return $this->redirect(['index']);
          } else {
          //  Yii::$app->session->setFlash('danger','Observación no agregada');
            throw new NotFoundHttpException("Ocurrió un error");
          }
        }
    }

    public function actionRechazar($id){
        $programa = $this->findModel($id);
        $programa->scenario = 'carrerap';
        $userId = \Yii::$app->user->identity->id;
        $estadoActual = Status::findOne($programa->status_id);
        if((PermisosHelpers::requerirProfesorAdjunto($id) && $estadoActual->descripcion == "Profesor") ||
          (PermisosHelpers::requerirDirector($id) && $estadoActual->descripcion == "Departamento") ||
          (PermisosHelpers::requerirRol("Adm_academica") && $estadoActual->descripcion == "Administración Académica") ||
          (PermisosHelpers::requerirRol("Sec_academica") && $estadoActual->descripcion == "Secretaría Académica")
        ){
          //$programa->status_id = Status::findOne(['descripcion','=','Departamento'])->id;

          $estadoSiguiente = Status::find()->where(['<','value',$estadoActual->value])->orderBy('value DESC')->one();
          if($estadoSiguiente->descripcion == "Profesor"){
            $estadoActual = $estadoSiguiente;
            $estadoSiguiente = Status::find()->where(['<','value',$estadoActual->value])->orderBy('value DESC')->one();
          }
          $programa->status_id = $estadoSiguiente->id;
          if( $programa->save()){
            Yii::$app->session->setFlash('warning','Se rechazó el programa correctamente');

            return $this->redirect(['index']);
          } else {
            throw new NotFoundHttpException("Ocurrió un error");
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
      $model = $this->findModel($id);
      $mpdf = new Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp']);
      $mpdf->WriteHTML($this->renderPartial('portada',['model'=>$model]));
      $mpdf->addPage();
      $mpdf->WriteHTML($this->renderPartial('paginas',['model'=>$model]));
      //$mpdf->WriteHTML('<h1>Hello World!</h1>');
      //$mpdf->Output($model->asignatura.".pdf", 'D');
      $mpdf->Output();

      //return $this->renderPartial('mpdf');
    }
}
