<?php

namespace frontend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
/* Searchs */
use common\models\search\MiProgramaSearch;
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
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use Mpdf;


/**
 * ProgramaController implements the CRUD actions for Programa model.
 */
class MiProgramaController extends Controller
{
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
                         'actions' => ['index', 'view','editar','export-pdf'],
                         'allow' => true,
                         'roles' => ['@'],
                         'matchCallback' => function ($rule, $action) {
                          return PermisosHelpers::requerirMinimoRol('Usuario')
                          && PermisosHelpers::requerirEstado('Activo');
                         }
                     ],

                     [
                          'actions' => [
                            'create','update','delete','anadir', 'ver',
                            'aprobar', 'rechazar','usuarios','lcrear',
                            'fundamentacion','asignar', 'copy',
                            'objetivo-plan', 'contenido-analitico',
                            'contenido-plan', 'eval-acred', 'propuesta-metodologica',
                            'parcial-rec-promo', 'dist-horaria', 'crono-tentativo',
                            'actividad-extracurricular', 'cargar',
                            'bibliografia','objetivo-programa','firma'
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
    public function actionError()

    {        

        if (Yii::$app->errorHandler->error['code'] == 403)

            $this->redirect('url');

        else

            $this->render('error');

    }
    /**
     * Lists all Programa models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MiProgramaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * Displays a single Programa model.
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

    public function actionVer($id) {
      $model = $this->findModel($id);

      if(Yii::$app->request->post('submit') == 'observacion' &&
          $model->load(Yii::$app->request->post()) && $model->save()) {
          return $this->redirect(['observacion/create', 'id'=>$model->id]);
      }

      return $this->render('info',['model' => $model]);

    }
    

    /**
     * Displays a single Designacion model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
  /*  public function actionVer($id)
    {
        $model = $this->findModel($id);
        $searchModelDesignacion = new DesignacionSearch();
        $dataProvDesignacion =  new ActiveDataProvider([
          'query' => $model->getDesignaciones()
        ]);
        return $this->render('ver', [
            'model' => $model,
            'dataProvDesignacion' => $dataProvDesignacion,
            'searchModelDesignacion' => $searchModelDesignacion
        ]);
    }*/

    public function actionAprobar($id){
        $programa = $this->findModel($id);
        $programa->scenario = 'carrerap';
        $userId = \Yii::$app->user->identity->id;
        $estadoActual = Status::findOne($programa->status_id);
        //$porcentajeCarga = 60; deprecated 19jul2022
        if ($estadoActual->descriptionIs(Status::BORRADOR)){
          if(!$programa->hasMinimumLoadPercentage()) {
            Yii::error("Error al enviar programa con ID: ".$id.", menos del ". Programa::MIN_LOAD_PERCENTAGE ." cargado",'estado-programa');
            Yii::$app->session->setFlash('danger','Debe completar el programa un 60%');
            return $this->redirect(['cargar','id' => $programa->id]);
          } else if ($programa->created_by == $userId){
            if ($programa->subirEstado() && $programa->save()) {
              Yii::info("Subió el estado del programa. BORRADOR->".$programa->getStatus()->one()->descripcion,'estado-programa');

              Yii::$app->session->setFlash('success','Se confirmó el programa exitosamente');
            } else {
              Yii::$app->session->setFlash('danger','Hubo un problema al confirmar el programa');
            }
            return $this->redirect(['index']);
          } else {
            Yii::warning("Intentó editar un programa ajeno. ID:".$id,'estado-programa');

          }
        }
       if (PermisosHelpers::requerirRol("Departamento")
        && $estadoActual->descriptionIs(Status::EN_ESPERA)
        && $programa->created_by != $userId ){
          Yii::$app->session->setFlash('danger','Debe pedir el programa antes de seguir');
          return $this->redirect(['index']);
       }
       if( (PermisosHelpers::requerirDirector($id) && ($estadoActual->descriptionIs(Status::DEPARTAMENTO))) ||
          (PermisosHelpers::requerirRol("Adm_academica") && $estadoActual->descriptionIs(Status::ADMINISTRACION_ACADEMICA)) ||
          (PermisosHelpers::requerirRol("Sec_academica") && $estadoActual->descriptionIs(Status::SECRETARIA_ACADEMICA))
        ){
          if($programa->subirEstado() && $programa->save()){
            Yii::info("Subió el estado del programa:".$id." Estaba en estado: ".$estadoActual->descripcion,'estado-programa');
            Yii::$app->session->setFlash('success','Se confirmó el programa exitosamente');
          } else {
            Yii::error("No pudo subir de estado ",'estado-programa');
            Yii::$app->session->setFlash('danger','Hubo un problema al intentar aprobar el programa');
          }
          return $this->redirect(['index']);
        }
    }

    public function actionRechazar($id){
        $programa = $this->findModel($id);
        $programa->scenario = 'carrerap';
        $userId = \Yii::$app->user->identity->id;
        $estadoActual = Status::findOne($programa->status_id);

        if ($estadoActual->descriptionIs(Status::BORRADOR) || $estadoActual->descriptionIs(Status::EN_ESPERA)){
          Yii::error("No pudo rechazar el programa ID:".$id." con estado:".$estadoActual->descripcion,'estado-programa');
          Yii::$app->session->setFlash('danger','Hubo un problema al intentar rechazar el programa');
          return $this->redirect(['index']);
        }
        if(PermisosHelpers::requerirDirector($id) && $estadoActual->descripcion == "Departamento"){
            if ($programa->setEstado("Borrador") && $programa->save()){
              Yii::info("Cambió el estado de Departamento -> Borrador ID:".$id,'estado-programa');
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
          if($programa->bajarEstado() &&  $programa->save()){
            Yii::info("Rechazó el programa".$id." con estado actual".$estadoActual->descripcion,'estado-programa');
            Yii::$app->session->setFlash('warning','Se rechazó el programa correctamente');
            return $this->redirect(['index']);
          } else {
            Yii::error("No pudo rechazar el programa ".$id." con estado actual".$estadoActual->descripcion,'estado-programa');
            Yii::$app->session->setFlash('danger','Hubo un problema al rechazar el programa');
            return $this->redirect(['index']);
          }
        }
    }


    /**
     * Creates a new Programa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Programa();
        $model->scenario = 'crear';
        // se crea en estado borrador
        $model->status_id = Status::find()->where(['=','descripcion','Borrador'])->one()->id;
        //obtener el id del director
        $userId = \Yii::$app->user->identity->id;
        if (PermisosHelpers::requerirRol('Departamento')){
          $depto = Departamento::find()->where(['=','director',$userId])->one();
          if (isset($depto)){
            //filtrar todas las asignaturas
            $searchModel = new AsignaturaSearch();
            $asignaturas = new ActiveDataProvider([
              //'query' => Asignatura::find()->where(['=','departamento_id',$depto->id])->all()
              'query' => $depto->getAsignaturas()
            ]);
            return $this->render('create', [
                'model' => $model,
                'asignaturas' => $asignaturas
            ]);
          } else {
            //no puede crear programas
          }
        }

        //$asignaturas =
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
    }
    /**
    * Edición del Punto 1 del programa -  Fundamentación
    * @param Integer $id del programa
    * @throws ForbiddenHttpException si no tiene permisos de modificar el programa
    */
    public function actionCargar($id)
    {
        $model = $this->findModel($id);
        // scenario para campo fundamentacion obligatorio
        $model->scenario = 'fundamentacion';
        $estado = Status::findOne($model->status_id);
        $validarPermisos = $this->validarPermisos($model, $estado);

        if ($validarPermisos) {
          // si es post realizo los cambios sobre el modelo
          if($model->load(Yii::$app->request->post())) {
              //intento de guardado
              if($model->save()){
                // LOG de éxito
                $this->mensajeGuardadoExito($model);
                // mensaje a usuario
                Yii::$app->session->setFlash('success','El programa se guardó exitosamente');
                //redireccion dependiendo del botón presionado
                if(Yii::$app->request->post('submit') == 'salir'){
                  return $this->redirect(['index']);
                }
                return $this->redirect(['objetivo-plan', 'id' => $model->id]);

              } else {
                // LOG de falla
                $this->mensajeGuardadoFalla($model);
                // mensaje a usuario
                Yii::$app->session->setFlash('danger','Hubo un problema al intentar guardar el programa');
              }
          }
          return $this->render('forms/_fundamentacion',['model'=>$model]);
        }
        throw new ForbiddenHttpException('No tiene permisos para actualizar este elemento');
    }

    /**
    *  Edición de campo Objetivo Plan de estudios
    *  @param integer $id del programa
    *  @return mixed
    * @throws ForbiddenHttpException si no tiene permisos de modificar el programa
    */
    public function actionObjetivoPlan($id){
      $model = $this->findModel($id);
      $model->scenario = 'obj-plan';
      $estado = Status::findOne($model->status_id);
      $validarPermisos = $this->validarPermisos($model, $estado);

      if ($validarPermisos) {
        //si es un POST cargo -> cargar datos al modelo
        if($model->load(Yii::$app->request->post()) ){
          // intento de guardado
          if($model->save()){
            // LOG de éxito
            $this->mensajeGuardadoExito($model);
            // mensaje a usuario
            Yii::$app->session->setFlash('success','El programa se guardó exitosamente');
            // redirección dependiendo el botón
            if(Yii::$app->request->post('submit') == 'salir'){
              return $this->redirect(['index']);
            }
            return $this->redirect(['objetivo-programa', 'id' => $model->id]);
          } else {
            // log de fallo
            $this->mensajeGuardadoFalla($model);
            // mensaje a usuario
            Yii::$app->session->setFlash('danger','Hubo un problema al guardar los cambios');
          }
        }

        return $this->render('forms/_objetivo-plan', [
            'model' => $model,
        ]);
      }
      throw new ForbiddenHttpException('No tiene permisos para actualizar este elemento');
    }

    /**
    *  Edición de campo Objetivo del programa
    *  @param integer $id del programa
    *  @return mixed
    * @throws ForbiddenHttpException si no tiene permisos de modificar el programa
    */
    public function actionObjetivoPrograma($id){
      $model = $this->findModel($id);
      $model->scenario = 'objetivo-programa';
      $estado = Status::findOne($model->status_id);
      $validarPermisos = $this->validarPermisos($model, $estado);

      if ($validarPermisos) {
        //si es un POST cargo -> cargar datos al modelo
        if($model->load(Yii::$app->request->post()) ){
          // intento de guardado
          if($model->save()){
            // LOG de éxito
            $this->mensajeGuardadoExito($model);
            // mensaje a usuario
            Yii::$app->session->setFlash('success','El objetivo del programa se guardó exitosamente');
            // redirección dependiendo el botón
            if(Yii::$app->request->post('submit') == 'salir'){
              return $this->redirect(['index']);
            }
            return $this->redirect(['contenido-plan', 'id' => $model->id]);
          } else {
            // log de fallo
            $this->mensajeGuardadoFalla($model);
            // mensaje a usuario
            Yii::$app->session->setFlash('danger','Hubo un problema al guardar los cambios');
          }
        }

        return $this->render('forms/_objetivo-programa', [
            'model' => $model,
        ]);
      }
      throw new ForbiddenHttpException('No tiene permisos para actualizar este elemento');
    }
    /**
    *  Edición de campo Contenido Plan de estudios
    *  @param integer $id del programa
    *  @return mixed
    * @throws ForbiddenHttpException si no tiene permisos de modificar el programa
    */
    public function actionContenidoPlan($id){
      $model = $this->findModel($id);
      $model->scenario = 'cont-plan';
      $estado = Status::findOne($model->status_id);
      $validarPermisos = $this->validarPermisos($model, $estado);

      if ($validarPermisos) {
        if ($model->load(Yii::$app->request->post())){
          if($model->save()){
            // LOG de éxito
            $this->mensajeGuardadoExito($model);
            // mensaje a usuario
            Yii::$app->session->setFlash('success','El contenido según el plan de estudio se guardó exitosamente');
            // redirección dependiendo el botón
            if(Yii::$app->request->post('submit') == 'salir'){
              return $this->redirect(['index']);
            }
            return $this->redirect(['contenido-analitico', 'id' => $model->id]);
          } else {
            // log de fallo
            $this->mensajeGuardadoFalla($model);
            // mensaje a usuario
            Yii::$app->session->setFlash('danger','Hubo un problema al guardar los cambios');
          }
        }

        return $this->render('forms/_contenido-plan', [
            'model' => $model,
        ]);
      }
      throw new ForbiddenHttpException('No tiene permisos para actualizar este elemento');
    }
    /**
    *  Edición de campo Contenido analítico
    *  @param integer $id del programa
    *  @return mixed
    * @throws ForbiddenHttpException si no tiene permisos de modificar el programa
    */
    public function actionContenidoAnalitico($id){
      $model = $this->findModel($id);
      $model->scenario = 'contenido_analitico';
      $estado = Status::findOne($model->status_id);
      $validarPermisos = $this->validarPermisos($model, $estado);

      if ($validarPermisos) {
        if ($model->load(Yii::$app->request->post())){
          if($model->save()){
            // LOG de éxito
            $this->mensajeGuardadoExito($model);
            // mensaje a usuario
            Yii::$app->session->setFlash('success','El contenido analítico se guardó exitosamente');
            // redirección dependiendo el botón
            if(Yii::$app->request->post('submit') == 'salir'){
              return $this->redirect(['index']);
            }
            return $this->redirect(['bibliografia', 'id' => $model->id]);
          } else {
            // log de fallo
            $this->mensajeGuardadoFalla($model);
            // mensaje a usuario
            Yii::$app->session->setFlash('danger','Hubo un problema al guardar los cambios');
          }
        }

        return $this->render('forms/_contenido-analitico', [
            'model' => $model,
        ]);
      }
      throw new ForbiddenHttpException('No tiene permisos para actualizar este elemento');
    }
    /**
    *  Edición de campo Bibliografía (consulta y básica)
    *  @param integer $id del programa
    *  @return mixed
    * @throws ForbiddenHttpException si no tiene permisos de modificar el programa
    */
    public function actionBibliografia($id){
      $model = $this->findModel($id);
      $model->scenario = 'bibliografia';
      $estado = Status::findOne($model->status_id);
      $validarPermisos = $this->validarPermisos($model, $estado);
      if ($model->biblio_basica == null)
        $model->biblio_basica = "<p><strong>Bibliograf&iacute;a b&aacute;sica</strong></p> <p>&nbsp;</p><p><strong>Bibliograf&iacute;a de consulta</strong></p>";
      
      if ($validarPermisos) {
        if ($model->load(Yii::$app->request->post())){
          if($model->save()){
            // LOG de éxito
            $this->mensajeGuardadoExito($model);
            // mensaje a usuario
            Yii::$app->session->setFlash('success','La bibliografía se guardó exitosamente');
            // redirección dependiendo el botón
            if(Yii::$app->request->post('submit') == 'salir'){
              return $this->redirect(['index']);
            }
            return $this->redirect(['propuesta-metodologica', 'id' => $model->id]);
          } else {
            // log de fallo
            $this->mensajeGuardadoFalla($model);
            // mensaje a usuario
            Yii::$app->session->setFlash('danger','Hubo un problema al guardar los cambios');
          }
        }

        return $this->render('forms/_bibliografia', [
            'model' => $model,
        ]);
      }
      throw new ForbiddenHttpException('No tiene permisos para actualizar este elemento');
    }
    /**
    *  Edición de campo de propuesta metodológica
    *  @param integer $id del programa
    *  @return mixed
    * @throws ForbiddenHttpException si no tiene permisos de modificar el programa
    */
    public function actionPropuestaMetodologica($id){
      $model = $this->findModel($id);
      $model->scenario = 'prop-met';
      $estado = Status::findOne($model->status_id);
      $validarPermisos = $this->validarPermisos($model, $estado);

      if ($validarPermisos) {
        if ($model->load(Yii::$app->request->post())){
          if($model->save()){
            // LOG de éxito
            $this->mensajeGuardadoExito($model);
            // mensaje a usuario
            Yii::$app->session->setFlash('success','La propuesta metodológica se guardó exitosamente');
            // redirección dependiendo el botón
            if(Yii::$app->request->post('submit') == 'salir'){
              return $this->redirect(['index']);
            }
            return $this->redirect(['eval-acred', 'id' => $model->id]);
          } else {
            // log de fallo
            $this->mensajeGuardadoFalla($model);
            // mensaje a usuario
            Yii::$app->session->setFlash('danger','Hubo un problema al guardar los cambios');
          }
        }

        return $this->render('forms/_propuesta-metodologica', [
            'model' => $model,
        ]);
      }
      throw new ForbiddenHttpException('No tiene permisos para actualizar este elemento');
    }
    /**
    *  Edición de campo de evaluación y acreditación
    *  @param integer $id del programa
    *  @return mixed
    * @throws ForbiddenHttpException si no tiene permisos de modificar el programa
    */
    public function actionEvalAcred($id){
      $model = $this->findModel($id);
      $model->scenario = 'eval-acred';
      $estado = Status::findOne($model->status_id);
      $validarPermisos = $this->validarPermisos($model, $estado);

      if ($validarPermisos) {
        if ($model->load(Yii::$app->request->post())){
          if($model->save()){
            // LOG de éxito
            $this->mensajeGuardadoExito($model);
            // mensaje a usuario
            Yii::$app->session->setFlash('success','Evaluación y condiciones de acreditación se guardó con éxito');
            // redirección dependiendo el botón
            if(Yii::$app->request->post('submit') == 'salir'){
              return $this->redirect(['index']);
            }
            return $this->redirect(['parcial-rec-promo', 'id' => $model->id]);
          } else {
            // log de fallo
            $this->mensajeGuardadoFalla($model);
            // mensaje a usuario
            Yii::$app->session->setFlash('danger','Hubo un problema al guardar los cambios');
          }
        }

        return $this->render('forms/_eval-acred', [
            'model' => $model,
        ]);
      }
      throw new ForbiddenHttpException('No tiene permisos para actualizar este elemento');
    }
    /**
    *  Edición de campo de parcial, recueratorio y promoción
    *  @param integer $id del programa
    *  @return mixed
    * @throws ForbiddenHttpException si no tiene permisos de modificar el programa
    */
    public function actionParcialRecPromo($id){
      $model = $this->findModel($id);
      $model->scenario = 'parc-rec-promo';
      $estado = Status::findOne($model->status_id);
      $validarPermisos = $this->validarPermisos($model, $estado);

      if ($validarPermisos) {
        if ($model->load(Yii::$app->request->post())){
          if($model->save()){
            // LOG de éxito
            $this->mensajeGuardadoExito($model);
            // mensaje a usuario
            Yii::$app->session->setFlash('success','La sección de parciales, recuperatorios y coloquios se guardó con éxito');
            // redirección dependiendo el botón
            if(Yii::$app->request->post('submit') == 'salir'){
              return $this->redirect(['index']);
            }
            return $this->redirect(['dist-horaria', 'id' => $model->id]);
          } else {
            // log de fallo
            $this->mensajeGuardadoFalla($model);
            // mensaje a usuario
            Yii::$app->session->setFlash('danger','Hubo un problema al guardar los cambios');
          }
        }

        return $this->render('forms/_parc-rec-promo', [
            'model' => $model,
        ]);
      }
      throw new ForbiddenHttpException('No tiene permisos para actualizar este elemento');
    }
    /**
    *  Edición de campo de distribución horaria
    *  @param integer $id del programa
    *  @return mixed
    * @throws ForbiddenHttpException si no tiene permisos de modificar el programa
    */
    public function actionDistHoraria($id){
      $model = $this->findModel($id);
      $model->scenario = 'dist-horaria';
      $estado = Status::findOne($model->status_id);
      $validarPermisos = $this->validarPermisos($model, $estado);

      if ($validarPermisos) {
        if ($model->load(Yii::$app->request->post())){
          if($model->save()){
            // LOG de éxito
            $this->mensajeGuardadoExito($model);
            // mensaje a usuario
            Yii::$app->session->setFlash('success','La sección de Distribución horaria se guardó con éxito');
            // redirección dependiendo el botón
            if(Yii::$app->request->post('submit') == 'salir'){
              return $this->redirect(['index']);
            }
            return $this->redirect(['crono-tentativo', 'id' => $model->id]);
          } else {
            // log de fallo
            $this->mensajeGuardadoFalla($model);
            // mensaje a usuario
            Yii::$app->session->setFlash('danger','Hubo un problema al guardar los cambios');
          }
        }

        return $this->render('forms/_dist-horaria', [
            'model' => $model,
        ]);
      }
      throw new ForbiddenHttpException('No tiene permisos para actualizar este elemento');
    }
    /**
    *  Edición de campo de cronograma tentativo
    *  @param integer $id del programa
    *  @return mixed
    * @throws ForbiddenHttpException si no tiene permisos de modificar el programa
    */
    public function actionCronoTentativo($id){
      $model = $this->findModel($id);
      $model->scenario = 'crono-tent';
      $estado = Status::findOne($model->status_id);
      $validarPermisos = $this->validarPermisos($model, $estado);
      if ($model->crono_tentativo == null ){
        $model->crono_tentativo = '
        <table style="border-collapse: collapse; height: 110px; border-color: black; border-style: solid; float: left;" border="1">
          <tbody>
          <tr style="height: 22px;">
          <th style="width: 400.2px; height: 22px;" colspan="5">Cuatrimestre</th>
          </tr>
          <tr style="height: 44px;">
          <th style="width: 106px; height: 44px;">Tiempo <br />/ Unidades</th>
          <th style="width: 68px; height: 44px;">Marzo</th>
          <th style="width: 53px; height: 44px;">Abril</th>
          <th style="width: 61px; height: 44px;">Mayo</th>
          <th style="width: 57px; height: 44px;">Junio</th>
          </tr>
          <tr style="height: 22px;">
          <td style="width: 106px; height: 22px;">Unidad 1</td>
          <td style="width: 68px; height: 22px;">X</td>
          <td style="width: 53px; height: 22px;">&nbsp;</td>
          <td style="width: 61px; height: 22px;">&nbsp;</td>
          <td style="width: 57px; height: 22px;">&nbsp;</td>
          </tr>
          <tr style="height: 22px;">
          <td style="width: 106px; height: 22px;">Unidad 2</td>
          <td style="width: 68px; height: 22px;">&nbsp;</td>
          <td style="width: 53px; height: 22px;">&nbsp;</td>
          <td style="width: 61px; height: 22px;">&nbsp;</td>
          <td style="width: 57px; height: 22px;">&nbsp;</td>
          </tr>
          </tbody>
          </table>
        ';
      }
      if ($validarPermisos) {
        if ($model->load(Yii::$app->request->post())){
          if($model->save()){
            // LOG de éxito
            $this->mensajeGuardadoExito($model);
            // mensaje a usuario
            Yii::$app->session->setFlash('success','La sección de cronograma tentativo se guardó con éxito');
            // redirección dependiendo el botón
            if(Yii::$app->request->post('submit') == 'salir'){
              return $this->redirect(['index']);
            }
            return $this->redirect(['actividad-extracurricular', 'id' => $model->id]);
          } else {
            // log de fallo
            $this->mensajeGuardadoFalla($model);
            // mensaje a usuario
            Yii::$app->session->setFlash('danger','Hubo un problema al guardar los cambios');
          }
        }

        return $this->render('forms/_crono-tentativo', [
            'model' => $model,
        ]);
      }
      throw new ForbiddenHttpException('No tiene permisos para actualizar este elemento');
    }
    /**
    *  Edición de campo de actividad extracurricular
    *  @param integer $id del programa
    *  @return mixed
    * @throws ForbiddenHttpException si no tiene permisos de modificar el programa
    */
    public function actionActividadExtracurricular($id){
      $model = $this->findModel($id);
      $model->scenario = 'actv-extra';
      $estado = Status::findOne($model->status_id);
      $validarPermisos = $this->validarPermisos($model, $estado);

      if ($validarPermisos) {
        if ($model->load(Yii::$app->request->post())){
          if($model->save()){
            // mensaje a usuario
            Yii::$app->session->setFlash('success','La sección de Actividad Extracurricular se guardó con éxito');
            // LOG de éxito
            $this->mensajeGuardadoExito($model);
            if(Yii::$app->request->post('submit') == 'salir'){
              return $this->redirect(['index']);
            }
            return $this->redirect(['firma', 'id' => $id]);
          } else {
            // mensaje a usuario
            Yii::$app->session->setFlash('danger','Hubo un problema al guardar los cambios');
            // log de fallo
            $this->mensajeGuardadoFalla($model);
          }
        }

        return $this->render('forms/_activ-extrac', [
            'model' => $model,
        ]);
      }
      throw new ForbiddenHttpException('No tiene permisos para actualizar este elemento');

    }
    /**
    *  Copiar un programa
    *  @param integer $id del programa
    *  @return mixed
    * @throws ForbiddenHttpException si no tiene permisos de copiar el programa
    */
    public function actionCopy($id){
      $model = $this->findModel($id);
      $model->scenario = 'copy';
      $estado = Status::findOne($model->status_id);
      $validarPermisos = $this->validarPermisos($model, $estado);
      if ($validarPermisos) {
        $modelNew = clone $model;
        $modelNew->scenario = 'copy';
        $modelNew->status_id = Status::find()->where(['=','descripcion','Borrador'])->one()->id;
        $modelNew->isNewRecord = true;
        $modelNew->id = null;
        $modelNew->departamento_id = null;
        $modelNew->setAsignatura('null');
        if ($modelNew->load(Yii::$app->request->post())){
          if($modelNew->save()){
            // mensaje a usuario
            Yii::$app->session->setFlash('success','Se ha generado una copia correctamente');
            // LOG de éxito
            $this->mensajeGuardadoExito($modelNew);
            
            return $this->redirect(['index']);
          } else {
            // mensaje a usuario
            Yii::$app->session->setFlash('danger','Hubo un problema al guardar los cambios');
            // log de fallo
            $this->mensajeGuardadoFalla($modelNew);
          }
        }
        
        return $this->render('forms/_copy', [
            'model' => $modelNew,
            'oldModel' => $model
        ]);
      }
      throw new ForbiddenHttpException('No tiene permisos realizar esta operación');

    }
    /**
    *  Edición de campo de actividad extracurricular
    *  @param integer $id del programa
    *  @return mixed
    * @throws ForbiddenHttpException si no tiene permisos de modificar el programa
    */
    public function actionFirma($id){
      $model = $this->findModel($id);
      $model->scenario = 'firma';
      $estado = Status::findOne($model->status_id);
      $validarPermisos = $this->validarPermisos($model, $estado);
      if($model->getFirma() == null){
        $html =
            '<div class="" style="text-align: center;">Firma del responsable <br />Aclaraci&oacute;n <br />Cargo</div>
            <div class="" style="text-align: center;">&nbsp;</div>
            <div class="" style="text-align: center;"><br />
            <div class="" style="text-align: right;">Lugar y fecha de entrega</div>
            </div>';
        $model->setFirma($html);
      }
      if ($validarPermisos) {
        if ($model->load(Yii::$app->request->post())){
          if($model->save()){
            // mensaje a usuario
            Yii::$app->session->setFlash('success','La sección de firma se guardó con éxito');
            // LOG de éxito
            $this->mensajeGuardadoExito($model);

            return $this->redirect(['index']);
          } else {
            // mensaje a usuario
            Yii::$app->session->setFlash('danger','Hubo un problema al guardar los cambios');
            // log de fallo
            $this->mensajeGuardadoFalla($model);
          }
        }
        return $this->render('forms/_firma', [
            'model' => $model,
        ]);
      }
      throw new ForbiddenHttpException('No tiene permisos para actualizar este elemento');
    }

    public function actionAnadir()
    {
          $model = new Programa();
          $model->scenario = 'crear';
          //$model->year =Yii::$app->formatter->asDatetime(date('Y-m-d'), "php:d-m-Y H:i:s");
          $model->status_id = Status::find()->where(['=','descripcion','Borrador'])->one()->id;
          //obtener el id del director
          if ($model->load(Yii::$app->request->post())) {
              //$yaExiste = Programa::find()->where(['=','asignatura_id',$model->asignatura_id]);
              //$yaExiste = $yaExiste->where(['=','year', $model->year])->one();
              //if($yaExiste)
              //  Yii::$app->session->setFlash('danger','El programa ya existe. Verifique la información');
              if($model->save()){
                Yii::$app->session->setFlash('warning','El programa se creó correctamente. <br>Complete el programa');
                $this->mensajeGuardadoExito($model);
                return $this->redirect(['cargar', 'id' => $model->id]);
              } else {
                Yii::$app->session->setFlash('danger','Hubo un problema al crear el programa');
                $this->mensajeGuardadoFalla($model);
              }
          } else {
                $model->year= date('Y');
          }

          return $this->render('anadir', [
              'model' => $model,
          ]);

    }
    public function actionAsignar($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'equipo_catedra';
          //$model->year =Yii::$app->formatter->asDatetime(date('Y-m-d'), "php:d-m-Y H:i:s");
          //$model->status_id = Status::find()->where(['=','descripcion','Borrador'])->one()->id;
          //obtener el id del director
        $userId = \Yii::$app->user->identity->id;
        if (!PermisosHelpers::requerirSerDueno($id)
          || !$model->getStatus()->one()->descripcion == "Borrador"){

          Yii::$app->session->setFlash('danger','No tiene permiso para esto');
          $this->mensajeGuardadoFalla($model);
          return $this->redirect(['index']);
        }
        if($model->load(Yii::$app->request->post()) && $model->save()){
            Yii::$app->session->setFlash('warning','El programa actualizó correctamente.');
            $this->mensajeGuardadoExito($model);
            return $this->redirect(['index']);
        }

        return $this->render('asignar', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing Programa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        //$designaciones = $model->getDesignaciones()->all();
        /*foreach ($designaciones as $key) {
          $key->delete();
        }*/
        $estado = $model->getStatus()->one()->getDescripcion();
        $userId = \Yii::$app->user->identity->id;
        

        $transaccion = Yii::$app->db->beginTransaction();
        try {
            if($estado == "Borrador" && $model->getCreatedBy() == $userId){
              $flag = true;
              if ($notifEmail = $model->getNotificationEmail()->all()) {
                foreach ($notifEmail as $notificacion) {
                  $notifID = $notificacion->id;
                  if($notificacion->delete()){
                    Yii::info("Se eliminó la notificacion".$notifID." por la acción de borrar programa: ".$id,'- miprograma');
                  } else {
                    $flag = false;
                    break;
                    $transaccion->rollBack();
                  }
                }
              }
              if ($notifPanel = $model->getNotificationPanel()->all()) {
                foreach ($notifPanel as $notificacion) {
                  $notifID = $notificacion->id;
                  if($notificacion->delete()){
                    Yii::info("Se eliminó la notificacion".$notifID." por la acción de borrar programa: ".$id,'- miprograma');
                  } else {
                    $flag = false;
                    break;
                    $transaccion->rollBack();
                  }
                }
              }
              if($observaciones = $model->getObservaciones()->all()){
                foreach ($observaciones as $obs) {
                  $obsId = $obs->id;
                  if($obs->delete()) {
                    Yii::info("Se eliminó la observación".$obsId." por la acción de borrar programa: ".$id,'- miprograma');
                  } else {
                    $flag = false;
                    break;
                    $transaccion->rollBack();
                  }
                }
              }
              
              if ($flag && $model->delete()){
                $transaccion->commit();
                Yii::$app->session->setFlash('success','El programa eliminó correctamente.');
                Yii::info("Eliminó el programa: ".$id,'miprograma');
              } else {
                $transaccion->rollBack();
                Yii::$app->session->setFlash('danger','El programa no se pudo eliminar.');
                Yii::error("No se pudo eliminar el programa: ".$id,'miprograma');
              }
            } else {
              Yii::$app->session->setFlash('danger','No puede realizar esta acción.');
            }
        } catch(Exception $e) {
          $transaccion->rollBack();
          Yii::error("No se pudo eliminar el programa: ".$id,'miprograma'. "Error de en transaction".$e);
        }
        return $this->redirect(['index']);
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
        if (($model = Programa::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('No se pudo encontrar lo que buscaba');
    }

    protected function validarPermisos($model, $estado) {
      if (!Yii::$app->user->isGuest) {
        $userId = \Yii::$app->user->identity->id;

        //if (PermisosHelpers::requerirRol('Profesor') &&
        //  ($estado->descripcion == "Profesor") && ($model->created_by == $userId)) {
        /*if (PermisosHelpers::requerirRol('Profesor') &&
          ($estado->descripcion == "Profesor")) {
            return true;
        } else if (PermisosHelpers::requerirDirector($model->id) &&
          ($estado->descripcion == "Borrador")) {
              return true;
        }*/
        if((PermisosHelpers::requerirMinimoRol('Profesor') && $userId == $model->created_by) || PermisosHelpers::requerirMinimoRol('Admin') ){
          return true;
        }
      }
      return false;
    }

    /*
    * Comienzan las funciones para crear y exportar un PDF
    */
    public function actionExportPdf($id){
      /*$model = $this->findModel($id);
      $mpdf = new Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp']);
      $mpdf->WriteHTML($this->renderPartial('../programa/portada',['model'=>$model]));
      $mpdf->addPage();
      $mpdf->WriteHTML($this->renderPartial('../programa/paginas',['model'=>$model]));
      //$mpdf->WriteHTML('<h1>Hello World!</h1>');
      //$mpdf->Output($model->asignatura.".pdf", 'D');
      $mpdf->Output();*/
      return $this->redirect(['programa/export-pdf', 'id' => $id]);

      //return $this->renderPartial('mpdf');
    }
    protected function mensajeGuardadoExito($model){
      Yii::info("Guardando el programa: ".$model->id,'miprograma');
    }
    protected function mensajeGuardadoFalla($model){
      Yii::error("Error al guardar el programa: ".$model->id,'miprograma');
    }
}
