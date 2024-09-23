<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Carrera;
use backend\models\CareerRelatedFileForm;
use yii\web\NotFoundHttpException;

class CarreraFilesController extends Controller
{

    public function actionUpload($id)
    {
        $model = $this->findModel($id);
        $uploadForm = new CareerRelatedFileForm($model);

        if ($uploadForm->load(Yii::$app->request->post()) && $uploadForm->upload()) {
            Yii::$app->session->setFlash('success', 'Archivo subido y guardado correctamente.');
            return $this->redirect(['carrera/view', 'id' => $model->id]);
        } else {
            return $this->render('@backend/views/carrera/upload_files', [
                'model' => $uploadForm,
            ]);
        }
    }

    protected function findModel($id)
    {
        if (($model = Carrera::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La carrera no existe');
    }
}
