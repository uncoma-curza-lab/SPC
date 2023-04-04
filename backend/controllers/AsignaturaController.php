<?php

namespace backend\controllers;

use Yii;
use common\models\Asignatura;
use common\models\PermisosHelpers;
use common\models\Plan;
use common\models\search\AsignaturaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * AsignaturaController implements the CRUD actions for Asignatura model.
 */
class AsignaturaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
           'access' => [
                  'class' => \yii\filters\AccessControl::class,
                  'rules' => [
                      [
                           'allow' => true,
                           'roles' => ['@'],
                           'matchCallback' => function($rule,$action) {
                             return PermisosHelpers::requerirMinimoRol('Admin')
                               && PermisosHelpers::requerirEstado('Activo');
                           }
                      ],
                  ]
           ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Asignatura models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AsignaturaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Asignatura model.
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
     * Creates a new Asignatura model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Asignatura();
        $model->scenario = 'create';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['asignatura/index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Asignatura model.
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
     * Deletes an existing Asignatura model.
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
     * Finds the Asignatura model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Asignatura the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Asignatura::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetCoursesByPlanId($course_id = null, $plan_id, $q = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $data = [];

        $plan = Plan::findOne($plan_id)->carrera->plan_vigente;

        $courses = $plan->getCoursesTree();

        if (!empty($courses)) {
            $data = array_filter(array_map(function($course) use($course_id, $plan_id) {
                if (
                    ($course_id && $course->id == $course_id)
                    ||
                    ($plan_id && $course->plan_id == $plan_id)

                ) {
                    return null;
                }
                return [
                    'id' => $course->id,
                    'text' => $course->nomenclatura,
                ];
            }, $courses));
        }

        return ['results' => array_values($data)];
    }
}
