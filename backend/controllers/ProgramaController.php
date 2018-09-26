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

/**
 * ProgramaController implements the CRUD actions for Programa model.
 */
class ProgramaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
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
        $searchModel = new ProgramaSearch();
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

    /**
     * Creates a new Programa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Programa();
        /*
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['pagina', 'id' => $model->id]);
        }*/
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['fundamentacion', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    public function actionFundamentacion($id){
      $model = $this->findModel($id);

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
          return $this->redirect(['objetivo-plan', 'id' => $model->id]);
      }

      return $this->render('forms/_fundamentacion', [
          'model' => $model,
      ]);
    }
    public function actionObjetivoPlan($id){
      $model = $this->findModel($id);
      if ($model->load(Yii::$app->request->post()) && $model->save()) {
          return $this->redirect(['contenido-plan', 'id' => $model->id]);
      }

      return $this->render('forms/_objetivo-plan', [
          'model' => $model,
      ]);
    }
    public function actionContenidoPlan($id){
      $model = $this->findModel($id);

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
          return $this->redirect(['contenido-analitico', 'id' => $model->id]);
      }

      return $this->render('forms/_contenido-plan', [
          'model' => $model,
      ]);
    }
    public function actionContenidoAnalitico($id){
      $model = $this->findModel($id);

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
          return $this->redirect(['propuesta-metodologica', 'id' => $model->id]);
      }

      return $this->render('forms/_contenido-analitico', [
          'model' => $model,
      ]);
    }

    public function actionPropuestaMetodologica($id){
      $model = $this->findModel($id);

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
          return $this->redirect(['eval-acred', 'id' => $model->id]);
      }

      return $this->render('forms/_propuesta-metodologica', [
          'model' => $model,
      ]);
    }

    public function actionEvalAcred($id){
      $model = $this->findModel($id);

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
          return $this->redirect(['parcial-rec-promo', 'id' => $model->id]);
      }

      return $this->render('forms/_eval-acred', [
          'model' => $model,
      ]);
    }

    public function actionParcialRecPromo($id){
      $model = $this->findModel($id);

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
          return $this->redirect(['dist-horaria', 'id' => $model->id]);
      }

      return $this->render('forms/_parc-rec-promo', [
          'model' => $model,
      ]);
    }

    public function actionDistHoraria($id){
      $model = $this->findModel($id);

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
          return $this->redirect(['crono-tentativo', 'id' => $model->id]);
      }

      return $this->render('forms/_dist-horaria', [
          'model' => $model,
      ]);
    }

    public function actionCronoTentativo($id){
      $model = $this->findModel($id);

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['actividad-extracurricular', 'id' => $model->id]);
      }

      return $this->render('forms/_crono-tentativo', [
          'model' => $model,
      ]);
    }

    public function actionActividadExtracurricular($id){
      $model = $this->findModel($id);

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
          return $this->redirect(['index']);
      }

      return $this->render('forms/_activ-extrac', [
          'model' => $model,
      ]);
    }

    /**
    * recibe un ID de programa y muestra el formulario para continuar con el mismo
    * Falta aplicar transacciones
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
                    return $this->redirect(['fundamentacion', 'id' => $model->id]);
        }

        return $this->render('update', [
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

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
