<?php

namespace frontend\controllers;

use Yii;
use common\models\Observacion;
use common\models\Programa;
use common\models\search\ObservacionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\PermisosHelpers;
use Exception;

/**
 * ObservacionController implements the CRUD actions for Observacion model.
 */
class ObservacionController extends Controller
{
    const CREAR_OBSERVACION = "crear-observacion";

    public function init() {
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                         'actions' => [
                            'index', 'view', 'create', 'update','delete',
                         ],
                         'allow' => true,
                         'roles' => ['@'],
                         'matchCallback' => function() {
                            if (!PermisosHelpers::requerirEstado('Activo')) {
                                return false;
                            }
                            if (PermisosHelpers::requerirMinimoRol('Adm_academica')) {
                                return true;
                            }

                            $syllabusId = Yii::$app->request->get('id');
                            if (!$syllabusId) {
                                return false;
                            }
                            $syllabus = Programa::findOne($syllabusId);
                            return $syllabus && (PermisosHelpers::requerirAuxDepartamento($syllabus) || PermisosHelpers::requerirSerDueno($syllabusId));
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
     * Lists all Observacion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ObservacionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Observacion model.
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
     * Creates a new Observacion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Observacion();
        $model->programa_id = $id;

        if ($model->load(Yii::$app->request->post())) {
          if($model->save()) {
            Yii::$app->session->setFlash('success','Observación agregada exitosamente');
            try {
                // generar notificación
                Yii::$app->GenerateNotification->creador(self::CREAR_OBSERVACION, $id);
            } catch (Exception $e) {
                Yii::error("Error al enviar observación: " . $e->getMessage());
            }
            return $this->redirect(['programa/ver', 'id' => $model->programa_id]);
          } else {
            Yii::$app->session->setFlash('danger','Observación no agregada');
          }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Observacion model.
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
     * Deletes an existing Observacion model.
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
     * Finds the Observacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Observacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Observacion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
