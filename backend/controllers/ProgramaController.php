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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['pagina', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
    * recibe un ID de programa y muestra el formulario para continuar con el mismo
    * Falta aplicar transacciones
    */
    public function actionPagina($id){
      $model = $this->findModel($id);
      if ($model->load(Yii::$app->request->post())){
        //procesa los objetivos
        $objetivos = $_POST['Programa']['objetivos'] ;
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
          return $this->render('pagina',['model'=>$model]);
        else
          return $this->redirect(['pagina','id'=>$model->id]);
      }
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
        $mUnidad->temas = $mUnidad->getTemas()->all();
        $array = [];
        foreach ($mUnidad->temas as $tkey => $tvalue) {
          array_push($array,$tvalue->descripcion);
        }
        $unidad = [
          "descripcion" => $mUnidad->descripcion,
          "temas" => $array,
          'biblio_basica' => $mUnidad->biblio_basica,
          'biblio_consulta' => $mUnidad->biblio_consulta
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
            return $this->redirect(['view', 'id' => $model->id]);
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
        $this->findModel($id)->delete();

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
