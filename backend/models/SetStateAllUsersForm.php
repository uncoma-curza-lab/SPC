<?php
namespace backend\models;

use Yii;

use yii\db\ActiveRecord;
use common\models\User;
//use common\models\Departamento;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use common\models\Estado;
use yii\imagine\Image;
use common\models\ValorHelpers;

    /**
     * Change password form for current user only
     */
class SetStateAllUsersForm extends \yii\db\ActiveRecord
{
        public $estado;
        /**
         * @var \common\models\User
         */
     
        /**
         * Creates a form model given a token.
         *
         * @param  string                          $token
         * @param  array                           $config name-value pairs that will be used to initialize the object properties
         * @throws \yii\base\InvalidParamException if token is empty or not valid
         */
        public function __construct( $config = [])
        {
           
            parent::__construct($config);
        }
     
        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [['estado'], 'required', 'message' => 'Es necesario este campo'],
                [['estado'], 'integer' ],
               
            ];
        }
      /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'estado' => 'Estado',

        ];
        
    }

   
}