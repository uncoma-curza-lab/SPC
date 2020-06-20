<?php

namespace frontend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
/* Searchs */
use common\models\search\ProgramaSearch;
use common\models\search\ProgramaEvaluacionSearch;
use common\models\search\AsignaturaSearch;
use common\models\search\DesignacionSearch;
/* Modelos */
use common\models\Programa;
use common\models\Designacion;
use common\models\Asignatura;
use common\models\Status;
use common\models\Departamento;

use common\models\PermisosHelpers;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Mpdf;


/**
 * ProgramaController implements the CRUD actions for Programa model.
 */
class ProgramaController extends Controller
{
    const RECHAZAR_PROGRAMA = 'rechazar-programa';
    const APROBAR_PROGRAMA = 'aprobar-programa';
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
          'access' => [
                 'class' => \yii\filters\AccessControl::className(),
                 /*'only' => [
                   'index', 'view', 'create', 'update','delete',
                   'ver', 'anadir','fundamentacion','cargar',
                   'fundamentacion', 'objetivo-plan', 'contenido-analitico',
                   'contenido-plan', 'eval-acred', 'propuesta-metodologica',
                   'parcial-rec-promo', 'dist-horaria', 'crono-tentativo',
                   'actividad-extracurricular', 'aprobar', 'rechazar'
                 ],*/
                 'rules' => [
                     [
                         'actions' => ['export-pdf'],
                         'allow' => true,
                         'roles' => ['@'],
                         'matchCallback' => function ($rule, $action) {
                          return PermisosHelpers::requerirMinimoRol('Usuario')
                          && PermisosHelpers::requerirEstado('Activo');
                         }
                     ],

                     [
                          'actions' => [
                            'anadir', 'ver',
                            'aprobar', 'rechazar', 'evaluacion'
                          ],
                          'allow' => true,
                          'roles' => ['@'],
                          'matchCallback' => function($rule,$action) {
                            return PermisosHelpers::requerirMinimoRol('Profesor')
                              && PermisosHelpers::requerirEstado('Activo');
                          }
                     ],
                     [
                          'actions' => [
                            'fundamentacion',
                            'objetivo-plan', 'contenido-analitico',
                            'contenido-plan', 'eval-acred', 'propuesta-metodologica',
                            'parcial-rec-promo', 'dist-horaria', 'crono-tentativo',
                            'actividad-extracurricular', 'cargar'
                          ],
                          'allow' => true,
                          'roles' => ['@'],
                          'matchCallback' => function($rule,$action) {
                            return PermisosHelpers::requerirRol('Profesor')
                              && PermisosHelpers::requerirEstado('Activo');
                          },

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
     * Lists all Programa models.
     * @return mixed
     */
    public function actionEvaluacion()
    {
        $searchModel = new ProgramaEvaluacionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('evaluacion', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        $porcentajeCarga = 40;
        if ($estadoActual->descripcion == "Borrador"){
          if($programa->calcularPorcentajeCarga() < $porcentajeCarga) {
            Yii::error("Error al enviar programa con ID: ".$id.", menos del ".$porcentajeCarga." cargado",'estado-programa');

            Yii::$app->session->setFlash('danger','Debe completar el programa un 40%');
            return $this->redirect(['cargar','id' => $programa->id]);
          } else if ($programa->created_by == $userId){
            if ($programa->subirEstado() && $programa->save()) {
              Yii::info("Subió el estado del programa. BORRADOR->".$programa->getStatus()->one()->descripcion,'estado-programa');
              Yii::$app->session->setFlash('success','Se confirmó el programa exitosamente');
              Yii::$app->GenerateNotification->suscriptores(self::APROBAR_PROGRAMA,$id);
            } else {
              Yii::$app->session->setFlash('danger','Hubo un problema al confirmar el programa');
            }
            return $this->redirect(['evaluacion']);
          } else {
            Yii::warning("Intentó editar un programa ajeno. ID:".$id,'estado-programa');
          }
        }
       if (PermisosHelpers::requerirRol("Departamento")
        && $estadoActual->descripcion == "Profesor"
        && $programa->created_by != $userId ){
          Yii::$app->session->setFlash('danger','Debe pedir el programa antes de seguir');
          return $this->redirect(['evaluacion']);
       }
       if( (PermisosHelpers::requerirDirector($id) && ($estadoActual->descripcion == "Departamento")) ||
          (PermisosHelpers::requerirRol("Adm_academica") && $estadoActual->descripcion == "Administración Académica") ||
          (PermisosHelpers::requerirRol("Sec_academica") && $estadoActual->descripcion == "Secretaría Académica")
        ){
          if($programa->subirEstado() && $programa->save()){
            Yii::info("Subió el estado del programa:".$id." Estaba en estado: ".$estadoActual->descripcion,'estado-programa');
            Yii::$app->session->setFlash('success','Se aprobó el programa exitosamente');
            
            Yii::$app->GenerateNotification->creador(self::APROBAR_PROGRAMA,$id);
            Yii::$app->GenerateNotification->suscriptores(self::APROBAR_PROGRAMA,$id);

            return $this->redirect(['evaluacion']);
          } else {
            Yii::error("No pudo subir de estado programa:".$id,'estado-programa');
            Yii::$app->session->setFlash('danger','Hubo un problema al intentar aprobar el programa');
            return $this->redirect(['evaluacion']);

          }
        }
    }
    
    public function actionRechazar($id){
        $programa = $this->findModel($id);
        $programa->scenario = 'carrerap';
        $userId = \Yii::$app->user->identity->id;
        $estadoActual = Status::findOne($programa->status_id);

        if ($estadoActual->descripcion == "Borrador" || $estadoActual->descripcion == "Profesor"){
          Yii::error("No pudo rechazar el programa ID:".$id." con estado:".$estadoActual->descripcion,'estado-programa');

          Yii::$app->session->setFlash('danger','Hubo un problema al intentar rechazar el programa');
          return $this->redirect(['evaluacion']);
        }
        if((PermisosHelpers::requerirDirector($id)  || PermisosHelpers::requerirMinimoRol("Admin")) && $estadoActual->descripcion == "Departamento"){
            if ($programa->setEstado("Borrador") && $programa->save()){
              Yii::info("Cambió el estado de Departamento -> Borrador ID:".$id,'estado-programa');

              Yii::$app->session->setFlash('warning','Se rechazó el programa correctamente');
              Yii::$app->GenerateNotification->creador(self::RECHAZAR_PROGRAMA,$id);
              Yii::$app->GenerateNotification->suscriptores(self::RECHAZAR_PROGRAMA,$id);

              return $this->redirect(['evaluacion']);
            } else {
              Yii::$app->session->setFlash('danger','Hubo un problema al rechazar el programa');
              return $this->redirect(['evaluacion']);
            }
        }

        if((PermisosHelpers::requerirRol("Adm_academica") && $estadoActual->descripcion == "Administración Académica") ||
          (PermisosHelpers::requerirRol("Sec_academica") && $estadoActual->descripcion == "Secretaría Académica") ||
          (PermisosHelpers::requerirMinimoRol("Admin"))
        ){
          //$programa->status_id = Status::findOne(['descripcion','=','Departamento'])->id;

          if($programa->bajarEstado() &&  $programa->save()){
            Yii::info("Rechazó el programa".$id." con estado actual".$estadoActual->descripcion,'estado-programa');
            Yii::$app->GenerateNotification->creador(self::RECHAZAR_PROGRAMA,$id);
            Yii::$app->GenerateNotification->suscriptores(self::RECHAZAR_PROGRAMA,$id);
            Yii::$app->session->setFlash('warning','Se rechazó el programa correctamente');
            return $this->redirect(['evaluacion']);
          } else {
            Yii::error("No pudo rechazar el programa ".$id." con estado actual".$estadoActual->descripcion,'estado-programa');

            Yii::$app->session->setFlash('danger','Hubo un problema al rechazar el programa');
            return $this->redirect(['evaluacion']);
          }
        }
    }

    /**
     * Finds the Programa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Programa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if(is_numeric($id)) {
            $model = Programa::find()->where('id = :id',[':id' => $id])->one();
            if ($model) {
              return $model;
            }
        }
        throw new NotFoundHttpException('No se pudo encontrar lo que buscaba');
    }

    protected function validarPermisos($model, $estado) {
      if (!Yii::$app->user->isGuest) {
        $userId = \Yii::$app->user->identity->id;

        //if (PermisosHelpers::requerirRol('Profesor') &&
        //  ($estado->descripcion == "Profesor") && ($model->created_by == $userId)) {
        if (PermisosHelpers::requerirRol('Profesor') &&
          ($estado->descripcion == "Profesor")) {
            return true;
        } else if (PermisosHelpers::requerirDirector($model->id) &&
          ($estado->descripcion == "Borrador")) {
              return true;
        }
        if(PermisosHelpers::requerirMinimoRol('Admin')){
          return true;
        }
      }
      return false;
    }

    /*
    * Comienzan las funciones para crear y exportar un PDF
    */
    public function actionExportPdf($id){
      $model = $this->findModel($id);
      $mpdf = new Mpdf\Mpdf(['utf-8','A4','tempDir' => __DIR__ . '/tmp']);
      //cargar style
      $stylesheet = file_get_contents('css/estilo-pdf.css');
      $mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
      //portada
      $mpdf->WriteHTML($this->renderPartial('portada',['model'=>$model]));
      $mpdf->addPage();
      //paginacion 
      $footer =  '<span style="font-size:12px; !important"> Página {PAGENO} de {nb}</span>';
      $mpdf->SetHTMLFooter($footer);
      //paginas siguientes
      $mpdf->WriteHTML($this->renderPartial('paginas',['model'=>$model]));
      $mpdf->Output();
    }
}
