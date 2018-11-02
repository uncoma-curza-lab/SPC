<?php

namespace backend\controllers;

use Yii;
use backend\models\Unidad;
use backend\models\UnidadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\PermisosHelpers;

/**
 * UnidadController implements the CRUD actions for Unidad model.
 */
class UnidadController extends Controller
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
                          return PermisosHelpers::requerirMinimoRol('Admin')
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
     * Lists all Unidad models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UnidadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Unidad model.
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
     * Creates a new Unidad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Unidad();
        $model->programa_id = $id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['tema/create', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Unidad model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['programa/contenido-analitico', 'id' => $model->programa_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionEdit($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('edit', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Unidad model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $temas = $model->getTemas()->all();
        foreach ($temas as $key) {
          $key->delete();
        }
        $programa_id = $model->programa_id;
        $model->delete();

        return $this->redirect(['programa/contenido-analitico', 'id' => $programa_id]);
    }


    /**
     * Finds the Unidad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Unidad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Unidad::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
