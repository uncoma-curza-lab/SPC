<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Csv;
use yii\web\UploadedFile;

class CsvController extends Controller
{
    public function actionIndex(){
      return $this->render('index');
    }
    public function actionCargar()
    {
        $model = new Csv();

        if (Yii::$app->request->isPost) {
            $model->File = UploadedFile::getInstance($model, 'File');
            if ($model->upload()) {
                // file is uploaded successfully
                $length = isset($this->fgetcsvOptions['length']) ? $this->fgetcsvOptions['length'] : 0;
                $delimiter = isset($this->fgetcsvOptions['delimiter']) ? $this->fgetcsvOptions['delimiter'] : ',';
                $enclosure = isset($this->fgetcsvOptions['enclosure']) ? $this->fgetcsvOptions['enclosure'] : '"';
                $escape = isset($this->fgetcsvOptions['escape']) ? $this->fgetcsvOptions['escape'] : "\\";
                $lines = [];
                if (($fp = fopen($this->filename, 'r')) !== FALSE) {
                  while (($line = fgetcsv($fp, $length, $delimiter, $enclosure, $escape)) !== FALSE) {
                      array_push($lines, $line);
                  }
                }
                return;
            }
        }

        return $this->render('cargar', ['model' => $model]);
    }
}
