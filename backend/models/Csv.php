<?php
namespace backend\models;

use yii\base\Model;
use yii\web\UploadedFile;

class Csv extends Model
{
    /**
     * @var UploadedFile
     */
    public $File;

    public $fgetOptions = ['length' => 0, 'delimiter' => ',', 'enclosure' => '"', 'escape' => "\\"];

    public $lineaInicial = 1;

    public function rules()
    {
        return [
            [
                ['File'], 'file', 'skipOnEmpty' => false,
                'extensions' => 'png, jpg, csv, pdf',
                'checkExtensionByMimeType' => false,
            ],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}
