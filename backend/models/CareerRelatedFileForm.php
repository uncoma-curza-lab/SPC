<?php

namespace backend\models;

use common\models\Carrera;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class CareerRelatedFileForm extends Model
{
    public $file;

    private $career;

    public function __construct(Carrera $career)
    {
        $this->career = $career;
    }

    public function rules()
    {
        return [
            [['file'], 'file', 'extensions' => ['pdf', 'png'], 'maxSize' => 1024 * 1024 * 5],
        ];
    }

    public function upload()
    {
        $this->file = UploadedFile::getInstance($this, 'file');
        if ($this->validate()) {

            $existingFiles = json_decode($this->career->related_files, true);
            if (isset($existingFiles['brochure']) && file_exists($existingFiles['brochure'])) {
                // remove file if exists
                unlink($existingFiles['brochure']);
            }

            $randomFileName = Yii::$app->security->generateRandomString() . '.' . $this->file->extension;
            $filePath = $this->getBasePath() . $randomFileName;

            if ($this->file->saveAs($filePath)) {
                $this->career->related_files = json_encode([
                    'brochure' => $filePath
                ]);

                return $this->career->save();
            }
        }

        return false;
    }

    public function getCareerId()
    {
        return $this->career->id;
    }

    public function getCareerName()
    {
        return $this->career->nom;
    }

    private function getBasePath(): string
    {
        $basePath = Yii::getAlias('@frontend/web/uploads/carrera/');
        if (!is_dir($basePath)) {
            mkdir($basePath, 0777, true);
        }
        return $basePath;
    }
}
