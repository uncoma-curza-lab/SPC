<?php

namespace backend\controllers;

use Yii;
use backend\models\Programa;
use backend\models\Unidad;
use backend\models\Tema;
use backend\models\ProgramaSearch;
use backend\models\Departamento;
use backend\models\DepartamentoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Objetivo;
use backend\models\Carrera;
use backend\models\Status;
use backend\models\CarreraPrograma;
use common\models\PermisosHelpers;
use Mpdf;

/**
 * Controlador de Programa
 * @author Julián Murphy
 */
class ProgramaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
          'access' => [
                 'class' => \yii\filters\AccessControl::className(),
                 'only' => [
                   'index', 'view', 'create', 'update','delete',
                   'fundamentacion', 'objetivo-plan', 'contenido-analitico',
                   'contenido-plan', 'eval-acred', 'propuesta-metodologica',
                   'parcial-rec-promo', 'dist-horaria', 'crono-tentativo',
                   'actividad-extracurricular'
                 ],
                 'rules' => [
                     [
                         'actions' => ['index', 'view'],
                         'allow' => true,
                         'roles' => ['@'],
                         'matchCallback' => function ($rule, $action) {
                          return PermisosHelpers::requerirMinimoRol('Usuario')
                          && PermisosHelpers::requerirEstado('Activo');
                         }
                     ],
                     [
                          'actions' => [
                            'create','update','delete','fundamentacion',
                            'objetivo-plan', 'contenido-analitico',
                            'contenido-plan', 'eval-acred', 'propuesta-metodologica',
                            'parcial-rec-promo', 'dist-horaria', 'crono-tentativo',
                            'actividad-extracurricular'
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
     * Listado de programas
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProgramaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra los datos del modelo
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException si el modelo no es encontrado
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $mostrar = false;

        if ( PermisosHelpers::requerirRol('Usuario') &&
         Status::findOne($model->status_id)->descripcion == 'Finalizado' ) {
            $mostrar = true;
        } else if (PermisosHelpers::requerirMinimoRol('Profesor')) {
            $mostrar = true;
        }
        if ( $mostrar )
          return $this->render('view', [
              'model' => $model,
          ]);

        throw new NotFoundHttpException('No tiene permisos para ver este elemento');


    }

    /**
     * Crea un programa nuevo
     * @deprecated no se utiliza
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Programa();
        $model->scenario = 'crear';
        //esta validación no es necesaria. Desde RULES se está validando
        if (PermisosHelpers::requerirMinimoRol('Profesor')) {
          if(Yii::$app->request->post('submit') == 'salir' &&
            $model->load(Yii::$app->request->post()) && $model->save()) {
              return $this->redirect(['index']);
          } else if(Yii::$app->request->post('submit') == 'cargo' &&
              $model->load(Yii::$app->request->post()) && $model->save()) {
              return $this->redirect(['cargo/create', 'id'=>$model->id]);
          } else if(Yii::$app->request->post('submit') == 'carrera' &&
              $model->load(Yii::$app->request->post()) && $model->save()) {
              return $this->redirect(['carrera-programa/create', 'id'=>$model->id]);
          } else if ($model->load(Yii::$app->request->post()) && $model->save()) {
              return $this->redirect(['fundamentacion', 'id' => $model->id]);
          }

          return $this->render('create', [
              'model' => $model,
          ]);
        }
        throw new NotFoundHttpException('No tiene permisos para crear este tipo de elementos');

    }

    /**
    *  Controla la vista _fundamentación
    *  $_POST Guarda el modelo y redirecciona a la siguiente vista
    *  @param integer $id del programa
    *  @return mixed
    */
    public function actionFundamentacion($id){

      $model = $this->findModel($id);
      $model->scenario = 'fundamentacion';
      $estado = Status::findOne($model->status_id);
      $validarPermisos = $this->validarPermisos($model, $estado);

      if ($validarPermisos) {
        if(Yii::$app->request->post('submit') == 'salir' &&
          $model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['objetivo-plan', 'id' => $model->id]);
        }

        return $this->render('forms/_fundamentacion', [
            'model' => $model,
        ]);
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
            return $this->redirect(['index']);
        } else if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
            return $this->redirect(['index']);
        } else if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
          $model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['propuesta-metodologica', 'id' => $model->id]);
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
          $model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['eval-acred', 'id' => $model->id]);
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
          $model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['parcial-rec-promo', 'id' => $model->id]);
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
          $model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['dist-horaria', 'id' => $model->id]);
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
          $model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['crono-tentativo', 'id' => $model->id]);
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
          $model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else if ($model->load(Yii::$app->request->post()) && $model->save()) {
              return $this->redirect(['actividad-extracurricular', 'id' => $model->id]);
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
          $model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('forms/_activ-extrac', [
            'model' => $model,
        ]);
      }
      throw new NotFoundHttpException('No tiene permisos para actualizar este elemento');

    }

    /**
    * recibe un ID de programa y muestra el formulario para continuar con el mismo
    * Falta aplicar transacciones
    * @deprecated no se utiliza más
    */
    public function actionPagina($id){
      //$model = DynamicModel::validateData([]);
      $model = $this->findModel($id);
      if ( $model->load(Yii::$app->request->post()) ){
        if($model->hasErrors()){
        //procesa los objetivos
        $objetivos = $_POST['Programa']['objetivos'];
        if(sizeof($objetivos) > 0)
        {
          $objetivos_aux = $model->getObjetivos()->all();
          foreach ($objetivos_aux as $key => $value) {
            $value->delete();
          }
          foreach ($objetivos['descripcion'] as $key => $value ) {
            $obj = new Objetivo();
            $obj->descripcion =$value;
            $obj->programa_id = $model->id;
            $obj->save();
          }
        }
        //procesa las unidades
        $unidades = $_POST['Programa']['unidades'];
        if (sizeof($unidades) > 0)
        {
          $unidades_aux = $model->getUnidades()->all();
          foreach ($unidades_aux as $key => $value) {
            $temas_aux = $value->getTemas()->all();
            foreach ($temas_aux as $tkey => $tvalue) {
              $tvalue->delete();
            }
            $value->delete();
          }
          foreach ($unidades as $key => $value) {
            $unidad = new Unidad();
            $unidad->descripcion = $value['descripcion'];
            $unidad->programa_id = $model->id;
            $unidad->biblio_basica = $value['biblio_basica'];
            $unidad->biblio_consulta = $value['biblio_consulta'];
            $unidad->crono_tent = $value['crono_tent'];
          // intenta guardar cada unidad
            $unidad->save();

            foreach ($value['temas']['temas'] as $indexTema => $descrTema) {
                $tema = new Tema();
                $tema->descripcion = $descrTema;
                $tema->unidad_id = $unidad->id;
                //inteta guardar cada tema
                $tema->save();
            }
          }
        }
        //intentamos guardar el modelo
        if (  $model->save() )
          //return $this->redirect(['view', 'id' => $model->id]);
          //return $this->render('pagina',['model'=>$model]);
          return $this->redirect(['index']);
        //else
          //return $this->redirect(['pagina','id'=>$model->id]);
      }}
      //prepara los objetivos para la vista
      $objetivos_aux = $model->getObjetivos()->all();
      $model->objetivos = $objetivos_aux;
      //prepara las unidades para la vista

      $unidades_aux = $model->getUnidades()->all();

      $unidades = [];
      foreach ($unidades_aux as $key => $unidad) {
        $mUnidad = new Unidad();
        $mUnidad->id = $unidad->id;
        $mUnidad->descripcion = $unidad['descripcion'];
        $mUnidad->programa_id = $model->id;
        $mUnidad->biblio_basica = $unidad['biblio_basica'];
        $mUnidad->biblio_consulta = $unidad['biblio_consulta'];
        $mUnidad->crono_tent = $unidad['crono_tent'];
        $mUnidad->temas = $mUnidad->getTemas()->all();
        $array = [];
        foreach ($mUnidad->temas as $tkey => $tvalue) {
          array_push($array,$tvalue->descripcion);
        }
        $unidad = [
          "descripcion" => $mUnidad->descripcion,
          "temas" => $array,
          'biblio_basica' => $mUnidad->biblio_basica,
          'biblio_consulta' => $mUnidad->biblio_consulta,
          'crono_tent' => $mUnidad->crono_tent,
        ];
        array_push($unidades,$unidad);
      }
      $model->unidades = $unidades;

      return $this->render('pagina', [
        'model' => $model
      ]);
    }

    /**
     * Actualiza un programa existente
     * Si se guarda de manera exitosa entonces redirecciona a fundamentacion
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException Si el modelo no se encuentra
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update';
        $estado = Status::findOne($model->status_id);
        $validarPermisos = $this->validarPermisos($model, $estado);

        if ($validarPermisos) {
            /*
            * Intenta hacer un save del post y
            * redirecciona a una vista según el botón
            */
            if(Yii::$app->request->post('submit') == 'salir' &&
              $model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            } else if(Yii::$app->request->post('submit') == 'cargo' &&
                $model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['cargo/create', 'id'=>$model->id]);
            } else if(Yii::$app->request->post('submit') == 'carrera' &&
                $model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['carrera-programa/create', 'id'=>$model->id]);
            } else if(Yii::$app->request->post('submit') == 'observacion' &&
                $model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['observacion/create', 'id'=>$model->id]);
            } else if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['fundamentacion', 'id' => $model->id]);
                //return $this->render('update',['model' => $model]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }
        throw new NotFoundHttpException('No tiene permisos para actualizar este elemento');
    }

    protected function validarPermisos($model, $estado) {
      $userId = \Yii::$app->user->identity->id;

      if (PermisosHelpers::requerirRol('Profesor') &&
        ($estado->descripcion == "Borrador") && ($model->created_by == $userId)) {
          return true;
      } else if (PermisosHelpers::requerirRol('Departamento') &&
        ($estado->descripcion == "Departamento")) {
          $perfil = \Yii::$app->user->identity->perfil;
          $carreras = $model->getCarreras();
          if ($carreras->where(['=','departamento_id', $perfil->departamento_id])->one()) {
            return true;
          }
      }
      if(PermisosHelpers::requerirMinimoRol('Admin')){
        return true;
      }
      return false;
    }

    /**
    *  Botón de guardado
    *  Si guarda el modelo entonces redirecciona al index
    *  @deprecated no está en funcionamiento
    *  @param integer $id del programa
    *  @return mixed
    */
    public function actionGuardarSalir($id)
    {
        $model = $this->findModel($id);
        $estado = Status::findOne($model->status_id);
        $validarPermisos = $this->validarPermisos($model, $estado);

        if ($validarPermisos) {
          if ($model->load(Yii::$app->request->post()) && $model->save()) {
                      return $this->redirect(['index', 'id' => $model->id]);
          }

          return $this->render('update', [
              'model' => $model,
          ]);
        }
        throw new NotFoundHttpException('No se puede realizar esta acción.');
    }

    /**
     * Elimina un programa existente
     * Si se elimina con éxito entonces redirecciona al index
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException si no existe el programa
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $estado = Status::findOne($model->status_id);
        //$validarPermisos = $this->validarPermisos($model, $estado);
        $userId = \Yii::$app->user->identity->id;

        if (PermisosHelpers::requerirRol('Profesor')
          && $model->created_by == $userId
          && $estado->descripcion == 'Borrador') {
          $unidades = $model->getUnidades()->all();
          $objetivos = $model->getObjetivos()->all();
          foreach ($unidades as $key) {
            $temas = $key->getTemas()->all();
            foreach ($temas as $tk) {
              $tk->delete();
            }
            $key->delete();
          }
          foreach ($objetivos as $key) {
            $key->delete();
          }

          $model->delete();

          return $this->redirect(['index']);
        }
        throw new NotFoundHttpException('No se puede eliminar');

    }
    /*
    * Comienzan las funciones para crear y exportar un PDF
    */
    public function actionExportPdf($id){
      $model = $this->findModel($id);
      $mpdf = new Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp']);
      $mpdf->WriteHTML($this->renderPartial('pdf',['model'=>$model]));
      //$mpdf->WriteHTML('<h1>Hello World!</h1>');
      //$mpdf->Output($model->asignatura.".pdf", 'D');
      $mpdf->Output();
      
      //return $this->renderPartial('mpdf');
    }
    public function actionForceDownloadPdf()
   {
       $mpdf = new Mpdf();
       $mpdf->WriteHTML($this->renderPartial('mpdf'));
       $mpdf->Output('MyPDF.pdf', 'D');
       exit;
   }
    /**
     * Busca un programa por su $id
     * Si el modelo no existe retorna un error 404
     * @param integer $id
     * @return Programa el modelo programa
     * @throws NotFoundHttpException si no se encuentra
     */
    protected function findModel($id)
    {
      $esusuario = PermisosHelpers::requerirMinimoRol('Usuario');
      $userId = \Yii::$app->user->identity->id;

      if (($model = Programa::findOne($id)) !== null) {
        if ($esusuario)
          return $model;

        throw new NotFoundHttpException('No se puede acceder al elemento.');

        /*if(PermisosHelpers::requerirRol('Profesor')){
          if ($model->created_by == $userId)
            return $model;
          throw new NotFoundHttpException('No se puede acceder al elemento.');
        } else if (PermisosHelpers::requerirRol('Departamento')) {
          $perfil = \Yii::$app->user->identity->perfil;
          $carreras = $model->getCarreras();
          if ( $carreras->where(['=','departamento_id', $perfil->departamento_id])->one()  ) {
            return $model;
          }
          throw new NotFoundHttpException('No se puede acceder al elemento.');*/
          //$carreraprograma =CarreraPrograma::find()->where(['=','programa_id',$model->id])->all();
          /*foreach ($carreraprograma as $carrera) {
            if ( Carrera::find()->where(['=','id',$carrera->carrera_id])->one()->departamento_id == $perfil->departamento_id )
              return $model;
          }*/

      }

      throw new NotFoundHttpException('No se puede acceder al elemento.');

    }

}
