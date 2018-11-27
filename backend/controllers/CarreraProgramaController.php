<?php

namespace backend\controllers;

use Yii;
use backend\models\CarreraPrograma;
use backend\models\CarreraProgramaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\PermisosHelpers;
use common\models\EstadoHelpers;
use backend\models\Programa;
use backend\models\Status;

/**
 * CarreraProgramaController implements the CRUD actions for CarreraPrograma model.
 */
class CarreraProgramaController extends Controller
{
    /**
     * {@inheritdoc}
     */
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
     * Lists all CarreraPrograma models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CarreraProgramaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CarreraPrograma model.
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
     * Creates a new CarreraPrograma model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new CarreraPrograma();
        $model->programa_id=$id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['programa/update', 'id' => $id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CarreraPrograma model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['programa/update', 'id' => $model->programa_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDesaprobar($id)
    {
        $model = $this->findModel($id);
        $model->estado = 0;

        if ($return = $model->save()) {
          $programa = Programa::findOne(['id','=',$model->programa_id]);
          $carrerasp = CarreraPrograma::find()->where(['=','programa_id',$model->id])->all();
          $programa->scenario = 'carrerap';
          $programa->status_id = 1;
          if ($programa->save()){
            foreach ($carrerasp as $key ) {
              $key->estado = null;
              $key->save();
            }
            return $this->redirect(['programa/index']);
            //CARTEL DE EXITO
            //return $this->redirect(['programa/update', 'id' => $model->programa_id]);
          }
        } else {
          throw new NotFoundHttpException($return);
        }

        return $this->redirect(['programa/status',
            'id' => $model->programa_id
        ]);
    }
    public function actionAprobar($id)
    {
        $model = $this->findModel($id);
        $model->estado = 1;
        if ($model->save()) {
          $programa = Programa::findOne(['=','id',$model->programa_id]);
          $programa->scenario = 'carrerap';
          $actualizar = true;
          $carrerasp = CarreraPrograma::find()->where(['=','programa_id',$model->id])->all();
          foreach ($carrerasp as $key ) {
            if ($key['estado'] != 1){
              $actualizar = false;
              break;
            }
          }
          if ($actualizar) {
            $valor_estado = Status::findOne(['=','id',$programa->status_id])->value;
            $siguiente_estado = Status::find()->where(['>','value',$valor_estado])->orderBy(['value'=>  SORT_ASC])->one();
            $programa->status_id = $siguiente_estado->id;
            //dejar todos los estados en falso
            foreach ($carrerasp as $key ) {
              $key->estado = null;
              $key->save();
            }
            if ($programa->save())
              $this->redirect(['programa/index']);
            else
              throw new NotFoundHttpException ("error cambio de estado");
          }
          //CARTEL DE EXITO
            //return $this->redirect(['programa/update', 'id' => $model->programa_id]);
        }
        return $this->redirect(['programa/status',
            'id' => $model->programa_id
        ]);
    }

    /**
     * Deletes an existing CarreraPrograma model.
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
     * Finds the CarreraPrograma model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CarreraPrograma the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CarreraPrograma::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
