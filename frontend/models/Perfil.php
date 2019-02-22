<?php

namespace frontend\models;

use Yii;

use yii\db\ActiveRecord;
use common\models\User;
//use common\models\Departamento;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

use yii\imagine\Image;


/**
 * This is the model class for table "perfil".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $nombre
 * @property string $apellido
 * @property string $fecha_nacimiento
 * @property integer $genero_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $localidad
 * @property string $telefono
 * @property string $cargo
 * @property string $imagen
 *
 * @property Genero $genero
 */
class Perfil extends \yii\db\ActiveRecord
{
    public $imageFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'perfil';
    }

/*   public function beforeValidate()
    {
        if ($this->fecha_nacimiento != null) {

            $nuevo_formato_fecha = date('Y-m-d', strtotime($this->fecha_nacimiento));
            $this->fecha_nacimiento = $nuevo_formato_fecha;
        }

            return parent::beforeValidate();
    }
    */


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'genero_id'], 'integer'],
            [['nombre', 'apellido'], 'string'],
            //[['localidad', 'telefono','cargo','imagen'], 'string','max'=>255],
            //[['imagen'], 'string','max'=>255],
            [['fecha_nacimiento', 'created_at', 'updated_at'], 'safe'],
            [['genero_id'],'in', 'range'=>array_keys($this->getGeneroLista())],
            [['fecha_nacimiento'], 'date', 'format'=>'php:Y-m-d'],
            [['imageFile'],'file','skipOnEmpty'=>true,'extensions'=>'jpg'], //'png,jpg'

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'genero_id' => 'Genero ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'generoNombre' => Yii::t('app', 'Genero'),
            'userLink' => Yii::t('app', 'User'),
            'perfilIdLink' => Yii::t('app', 'Perfil'),
            'imageFile'=>'Foto',
            //'imagen'=>'Imagen',

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenero()
    {
        return $this->hasOne(Genero::className(), ['id' => 'genero_id']);
    }


       /**
        * behaviors
        */

    public function behaviors()
    {
        return [
            'timestamp' => [
            'class' => 'yii\behaviors\TimestampBehavior',
            'attributes' => [
                                ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                                ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                            ],
            'value' => new Expression('NOW()'),
                           ],
               ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getGeneroNombre()
    {
        return $this->genero->genero_nombre;
    }
    /**
     * get lista de generos para lista desplegable
     */

    public static function getGeneroLista()
    {
        $droptions = Genero::find()->asArray()->all();
        return ArrayHelper::map($droptions, 'id', 'genero_nombre');
    }
  /**
  * @deprecated
  */
  /*
    public static function getDepartamentoLista()
    {
        $droptions = Departamento::find()->asArray()->all();
        return ArrayHelper::map($droptions, 'id', 'nom');
    }
    */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @get Username
     */
    public function getUsername()
    {
        return $this->user->username;
    }
    /**
     * @getUserId
     */
    public function getUserId()
    {
        return $this->user ? $this->user->id : 'none';
    }

    /**
     * @getUserLink
     */

    public function getUserLink()
    {
        $url = Url::to(['user/view', 'id'=>$this->UserId]);
        $opciones = [];
        return Html::a($this->getUserName(), $url, $opciones);
    }
    /**
     * @getProfileLink
     */

    public function getPerfilIdLink()
    {
        $url = Url::to(['perfil/update', 'id'=>$this->id]);
        $opciones = [];
        return Html::a($this->id, $url, $opciones);
    }


    public function upload(){
        if($this->imageFile){
            $path=Url::to('@webroot/images/photos/');
            $fileName = strToLower($this->user_id).'.jpg';
            $this->imageFile->saveAs($path.$fileName);
            $this->imagen=$fileName;
            //Image::frame($this->imageFile->tempName,20,'00FF00',100)->save($path.$fileName,['quality'=>90]);
            //Image::thumbnail($this->imageFile->tempName,180,180)->save($path.$fileName,['quality'=>90]);
        }
        return true;
    }

    public function beforeSave($insert){
        if (parent::beforeSave($insert)){
            $this->upload();
            return true;
        }else{
            return false;
        }
    }

    public function getPhotoInfo(){

        $path=Url::to('@webroot/images/photos/');
        $url=Url::to('@web/images/photos/');
        $fileName=$this->user_id . '.jpg';
        $alt = "Foto de id:".$this->id;
        $imageInfo=['alt'=>$alt];

        if(file_exists($path.$fileName)){
            $imageInfo['url']=$url.$fileName;
        }else{
            $imageInfo['url']=$url.'default.jpg';
        }
        return $imageInfo;

    }

    public function beforeDelete(){
        if(parent::beforeDelete()){
            $path=Url::to('@webroot/images/photos/');
            $fileName = $this->user_id.'.jpg';
            if(is_file($path.$fileName)){
                unlink($path.$fileName);
            }
            return true;
        }else{
            return false;
        }
    }
    public function printNombre(){
      return $this->apellido." ".$this->nombre;
    }
/*    public static function listaCargos(){
        return ArrayHelper::getColumn(Perfil::find()->select(['cargo'])->distinct()->all(),'cargo');
    }    */

    /*public static function listaLocalidades(){
        return ArrayHelper::getColumn(Perfil::find()->select(['localidad'])->distinct()->all(),'localidad');
    } */

}
