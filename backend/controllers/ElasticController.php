<?php

namespace backend\controllers;

use Yii;
use common\models\DepartamentoElastic;
use common\models\Departamento;

use common\models\PermisosHelpers;
use common\models\search\DesignacionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DesignacionController implements the CRUD actions for Designacion model.
 */
class ElasticController extends Controller
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
    public function actionUpdateModels(){
        
        if (Yii::$app->request->post()) {
            $dptos = Departamento::find()->all();
            foreach ($dptos as $key) {
                $dptoElastic = new DepartamentoElastic();
                $dptoElastic->primaryKey = $key->id;
                $dptoElastic->nom = $key->nom;
                $dptoElastic->director = $key->director;
                $dptoElastic->insert();
            }

            echo "return";
        }
        return $this->render('update');
    }

}
