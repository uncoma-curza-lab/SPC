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
                            'fundamentacion',
                            'objetivo-plan', 'contenido-analitico',
                            'contenido-plan', 'eval-acred', 'propuesta-metodologica',
                            'parcial-rec-promo', 'dist-horaria', 'crono-tentativo',
                            'actividad-extracurricular', 'cargar'
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
        if((PermisosHelpers::requerirProfesorAdjunto($id) && $estadoActual->descripcion == "Profesor") && $programa->calcularPorcentajeCarga() < 100){
              Yii::$app->session->setFlash('danger','Debe completar el programa un 100%');
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

    public function actionCargar($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'fundamentacion';
        $estado = Status::findOne($model->status_id);
        $validarPermisos = $this->validarPermisos($model, $estado);

        if ($validarPermisos) {
          if(Yii::$app->request->post('submit') == 'salir' &&
            $model->load(Yii::$app->request->post())) {
              if($model->save()){
                Yii::$app->session->setFlash('success','El programa se guardó exitosamente');
                return $this->redirect(['index']);
              } else {
                Yii::$app->session->setFlash('danger','Hubo un problema al intentar guardar el programa');
              }
          } else if ($model->load(Yii::$app->request->post())) {
              if($model->save()){
                Yii::$app->session->setFlash('success','Se guardó fundamentación exitosamente');
                return $this->redirect(['objetivo-plan', 'id' => $model->id]);
              } else {
                Yii::$app->session->setFlash('danger','Hubo un problema al intentar guardar el programa');
              }
          }
          return $this->render('forms/_fundamentacion',['model'=>$model]);
        }
        throw new NotFoundHttpException('No tiene permisos para actualizar este elemento');
    }

    /**
    *  Controla la vista _objetivo-plan
    *  $_POST Guarda el modelo y redirecciona a la siguiente vista
    *  @param integer $id del programa
    *  @return mixed
    */
    public function actionObjetivoPlan($id){
      $model = $this->findModel($id);
      $model->scenario = 'obj-plan';
      $estado = Status::findOne($model->status_id);
      $validarPermisos = $this->validarPermisos($model, $estado);

      if ($validarPermisos) {
        if(Yii::$app->request->post('submit') == 'salir' &&
          $model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success','El programa se guardó exitosamente');
            return $this->redirect(['index']);
        } else if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success','Objetivos según el plan de estudio se guardó exitosamente');
            return $this->redirect(['contenido-plan', 'id' => $model->id]);
        }

        return $this->render('forms/_objetivo-plan', [
            'model' => $model,
        ]);
      }
      throw new NotFoundHttpException('No tiene permisos para actualizar este elemento');
    }

    /**
    *  Controla la vista _contenido-plan
    *  $_POST Guarda el modelo y redirecciona a la siguiente vista
    *  @param integer $id del programa
    *  @return mixed
    */
    public function actionContenidoPlan($id){
      $model = $this->findModel($id);
      $model->scenario = 'cont-plan';
      $estado = Status::findOne($model->status_id);
      $validarPermisos = $this->validarPermisos($model, $estado);

      if ($validarPermisos) {
        if(Yii::$app->request->post('submit') == 'salir' &&
          $model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success','El programa se guardó exitosamente');
            return $this->redirect(['index']);
        } else if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success','El contenido según el plan de estudio se guardó exitosamente');
            return $this->redirect(['contenido-analitico', 'id' => $model->id]);
        }

        return $this->render('forms/_contenido-plan', [
            'model' => $model,
        ]);
      }
      throw new NotFoundHttpException('No tiene permisos para actualizar este elemento');
    }
    /**
    *  Controla la vista _contenido-analitico
    *  $_POST Guarda el modelo y redirecciona a la siguiente vista
    *  @param integer $id del programa
    *  @return mixed
    */
    public function actionContenidoAnalitico($id){
      $model = $this->findModel($id);
      $model->scenario = 'cont-analitico';
      $estado = Status::findOne($model->status_id);
      $validarPermisos = $this->validarPermisos($model, $estado);

      if ($validarPermisos) {
        if(Yii::$app->request->post('submit') == 'salir' &&
          $model->load(Yii::$app->request->post())) {
            if($model->save()){
              Yii::$app->session->setFlash('success','El programa se guardó exitosamente');
              return $this->redirect(['index']);
            } else {
              Yii::$app->session->setFlash('danger','Hubo un problema al guardar');
            }
        } else if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
              Yii::$app->session->setFlash('success','El contenido analítico se guardó exitosamente');
              return $this->redirect(['propuesta-metodologica', 'id' => $model->id]);
            } else {
              Yii::$app->session->setFlash('danger','Hubo un problema al guardar');
            }
        }

        return $this->render('forms/_contenido-analitico', [
            'model' => $model,
        ]);
      }
      throw new NotFoundHttpException('No tiene permisos para actualizar este elemento');
    }
    /**
    *  Controla la vista _propuesta-metodologica
    *  $_POST Guarda el modelo y redirecciona a la siguiente vista
    *  @param integer $id del programa
    *  @return mixed
    */
    public function actionPropuestaMetodologica($id){
      $model = $this->findModel($id);
      $model->scenario = 'prop-met';
      $estado = Status::findOne($model->status_id);
      $validarPermisos = $this->validarPermisos($model, $estado);

      if ($validarPermisos) {
        if(Yii::$app->request->post('submit') == 'salir' &&
          $model->load(Yii::$app->request->post())) {
            if($model->save()){
              Yii::$app->session->setFlash('success','El programa se guardó exitosamente');
              return $this->redirect(['index']);
            } else {
              Yii::$app->session->setFlash('danger','hubo problemas al guardar la propuesta metodológica');
            }
        } else if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
              Yii::$app->session->setFlash('success','La propuesta metodológica se guardó exitosamente');
              return $this->redirect(['eval-acred', 'id' => $model->id]);
            } else {
              Yii::$app->session->setFlash('danger','hubo problemas al guardar la propuesta metodológica');
            }

        }

        return $this->render('forms/_propuesta-metodologica', [
            'model' => $model,
        ]);
      }
      throw new NotFoundHttpException('No tiene permisos para actualizar este elemento');
    }
    /**
    *  Controla la vista _eval-acred
    *  $_POST Guarda el modelo y redirecciona a la siguiente vista
    *  @param integer $id del programa
    *  @return mixed
    */
    public function actionEvalAcred($id){
      $model = $this->findModel($id);
      $model->scenario = 'eval-acred';
      $estado = Status::findOne($model->status_id);
      $validarPermisos = $this->validarPermisos($model, $estado);

      if ($validarPermisos) {
        if(Yii::$app->request->post('submit') == 'salir' &&
          $model->load(Yii::$app->request->post())) {
            if ($model->save()) {
              Yii::$app->session->setFlash('success','El programa se guardó con éxito');
              return $this->redirect(['index']);
            } else {
              Yii::$app->session->setFlash('danger','hubo problemas al guardar Evaluación y condiciones de acreditación');
            }
        } else if ($model->load(Yii::$app->request->post()) ) {
            if ($model->save()) {
              Yii::$app->session->setFlash('success','Evaluación y condiciones de acreditación se guardó con éxito');
              return $this->redirect(['parcial-rec-promo', 'id' => $model->id]);
            } else {
              Yii::$app->session->setFlash('danger','Hubo problemas al guardar Evaluación y condiciones de acreditación');
            }
        }

        return $this->render('forms/_eval-acred', [
            'model' => $model,
        ]);
      }
      throw new NotFoundHttpException('No tiene permisos para actualizar este elemento');
    }
    /**
    *  Controla la vista _parc-rec-promo
    *  $_POST Guarda el modelo y redirecciona a la siguiente vista
    *  @param integer $id del programa
    *  @return mixed
    */
    public function actionParcialRecPromo($id){
      $model = $this->findModel($id);
      $model->scenario = 'parc-rec-promo';
      $estado = Status::findOne($model->status_id);
      $validarPermisos = $this->validarPermisos($model, $estado);

      if ($validarPermisos) {
        if(Yii::$app->request->post('submit') == 'salir' &&
          $model->load(Yii::$app->request->post())) {
            if ($model->save()) {
              Yii::$app->session->setFlash('success','El programa se guardó con éxito');
              return $this->redirect(['index']);
            } else {
              Yii::$app->session->setFlash('danger','Hubo problemas al guardar la sección de parciales, recuperatorios y coloquios');
            }
        } else if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
              Yii::$app->session->setFlash('success','La sección de parciales, recuperatorios y coloquios se guardó con éxito');
              return $this->redirect(['dist-horaria', 'id' => $model->id]);
            } else {
              Yii::$app->session->setFlash('danger','Hubo problemas al guardar la sección de parciales, recuperatorios y coloquios');
            }
        }

        return $this->render('forms/_parc-rec-promo', [
            'model' => $model,
        ]);
      }
      throw new NotFoundHttpException('No tiene permisos para actualizar este elemento');
    }
    /**
    *  Controla la vista _dist-horaria
    *  $_POST Guarda el modelo y redirecciona a la siguiente vista
    *  @param integer $id del programa
    *  @return mixed
    */
    public function actionDistHoraria($id){
      $model = $this->findModel($id);
      $model->scenario = 'dist-horaria';
      $estado = Status::findOne($model->status_id);
      $validarPermisos = $this->validarPermisos($model, $estado);

      if ($validarPermisos) {
        if(Yii::$app->request->post('submit') == 'salir' &&
          $model->load(Yii::$app->request->post())) {
            if ($model->save()) {
              Yii::$app->session->setFlash('success','El programa se guardó con éxito');
              return $this->redirect(['index']);
            } else {
              Yii::$app->session->setFlash('danger','Hubo problemas al guardar la sección de Distribución horaria');
            }
        } else if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
              Yii::$app->session->setFlash('success','La sección de Distribución horaria se guardó con éxito');
              return $this->redirect(['crono-tentativo', 'id' => $model->id]);
            } else {
              Yii::$app->session->setFlash('danger','Hubo problemas al guardar la sección de Distribución horaria');
            }
        }

        return $this->render('forms/_dist-horaria', [
            'model' => $model,
        ]);
      }
      throw new NotFoundHttpException('No tiene permisos para actualizar este elemento');
    }
    /**
    *  Controla la vista _crono-tentativo
    *  $_POST Guarda el modelo y redirecciona a la siguiente vista
    *  @param integer $id del programa
    *  @return mixed
    */
    public function actionCronoTentativo($id){
      $model = $this->findModel($id);
      $model->scenario = 'crono-tent';
      $estado = Status::findOne($model->status_id);
      $validarPermisos = $this->validarPermisos($model, $estado);

      if ($validarPermisos) {
        if(Yii::$app->request->post('submit') == 'salir' &&
          $model->load(Yii::$app->request->post())) {
            if ($model->save()) {
              Yii::$app->session->setFlash('success','El programa se guardó con éxito');
              return $this->redirect(['index']);
            } else {
              Yii::$app->session->setFlash('danger','Hubo problemas al guardar la sección de cronograma tentativo');
            }
        } else if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
              Yii::$app->session->setFlash('success','La sección de cronograma tentativo se guardó con éxito');
              return $this->redirect(['actividad-extracurricular', 'id' => $model->id]);
            } else {
              Yii::$app->session->setFlash('danger','Hubo problemas al guardar la sección de cronograma tentativo');
            }
        }

        return $this->render('forms/_crono-tentativo', [
            'model' => $model,
        ]);
      }
      throw new NotFoundHttpException('No tiene permisos para actualizar este elemento');
    }
    /**
    *  Controla la vista _activ-extrac
    *  $_POST Guarda el modelo y redirecciona a la siguiente vista
    *  @param integer $id del programa
    *  @return mixed
    */
    public function actionActividadExtracurricular($id){
      $model = $this->findModel($id);
      $model->scenario = 'actv-extra';
      $estado = Status::findOne($model->status_id);
      $validarPermisos = $this->validarPermisos($model, $estado);

      if ($validarPermisos) {
        if(Yii::$app->request->post('submit') == 'salir' &&
          $model->load(Yii::$app->request->post())) {
            if ($model->save()) {
              Yii::$app->session->setFlash('success','El programa se guardó con éxito');
              return $this->redirect(['index']);
            } else {
              Yii::$app->session->setFlash('danger','Hubo problemas al guardar la sección de actividades extracurriculares');
            }
        } else if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
              Yii::$app->session->setFlash('success','El programa se guardó con éxito');
              return $this->redirect(['index']);
            } else {
              Yii::$app->session->setFlash('danger','Hubo problemas al guardar la sección de actividades extracurriculares');
            }
        }

        return $this->render('forms/_activ-extrac', [
            'model' => $model,
        ]);
      }
      throw new NotFoundHttpException('No tiene permisos para actualizar este elemento');

    }

    public function actionAnadir()
    {
          $model = new Programa();
          $model->scenario = 'crear';
          //$model->year =Yii::$app->formatter->asDatetime(date('Y-m-d'), "php:d-m-Y H:i:s");
          $model->status_id = Status::find()->where(['=','descripcion','Borrador'])->one()->id;
          //obtener el id del director
          $userId = \Yii::$app->user->identity->id;
            if ($model->load(Yii::$app->request->post())) {
              //$yaExiste = Programa::find()->where(['=','asignatura_id',$model->asignatura_id]);
              //$yaExiste = $yaExiste->where(['=','year', $model->year])->one();
              //if($yaExiste)
              //  Yii::$app->session->setFlash('danger','El programa ya existe. Verifique la información');
              if($model->save()){
                Yii::$app->session->setFlash('warning','El programa se creó correctamente. <br>Complete el programa');
                return $this->redirect(['cargar', 'id' => $model->id]);
              }
            } else {
                $model->year= date('Y');
            }


            return $this->render('anadir', [
                'model' => $model,
            ]);

    }


  /*  public function actionEnviarProfesor($id)
    {
      $model = $this->findModel($id);
      $model->scenario = 'enviarProfesor';
      $nuevo_status = Status::find()->where(['=','descripcion','Profesor'])->one();
      $model->status_id = $nuevo_status->id;
      if ($model->save()) {
        //enviar al profesor en estado
        return $this->redirect(['index']);
      }
    }

    public function actionAsignar($id) {
      if(Yii::$app->request->post('submit') == 'designacion' &&
        $model->load(Yii::$app->request->post()) && $model->save()) {
          return $this->redirect(['anadir']);
      } else {
        $asignaturaId = $id;
        $asignatura = Asignatura::findOne($asignaturaId);
        if(isset($asignatura))
        {
          $model = new Programa();
          $model->scenario = 'crear';
          // se crea en estado borrador
          $model->status_id = Status::find()->where(['=','descripcion','Borrador'])->one()->id;
          $model->asignatura_id = $asignaturaId;
          $designacion = new Designacion();

          if ($model->save()){
            $designacion->programa_id = $model->id;
            return $this->render('asignar', [
                'model' => $model,
                'designacion' => $designacion,
            ]);
          }
        }
      }

    }*/

    /**
     * Updates an existing Programa model.
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
    public function actionEditar($id)
    {
        if(PermisosHelpers::requerirDirector($id)){
          $model = $this->findModel($id);
          $searchModel = new ProgramaSearch();
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
     * Deletes an existing Programa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $designaciones = $model->getDesignaciones()->all();
        foreach ($designaciones as $key) {
          $key->delete();
        }
        $model->delete();

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
        if(PermisosHelpers::requerirMinimoRol('Profesor')){
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
