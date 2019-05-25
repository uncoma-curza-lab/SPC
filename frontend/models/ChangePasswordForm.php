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
     * Change password form for current user only
     */
    class ChangePasswordForm extends \yii\db\ActiveRecord
    {
        public $id;
        public $password;
        public $confirm_password;
        public $old_password;
        /**
         * @var \common\models\User
         */
        private $_user;
     
        /**
         * Creates a form model given a token.
         *
         * @param  string                          $token
         * @param  array                           $config name-value pairs that will be used to initialize the object properties
         * @throws \yii\base\InvalidParamException if token is empty or not valid
         */
        public function __construct($id, $config = [])
        {
            $this->_user = User::findIdentity($id);
            
            if (!$this->_user) {
                throw new InvalidParamException('Unable to find user!');
            }
            
            $this->id = $this->_user->id;
            parent::__construct($config);
        }
     
        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [['old_password','password','confirm_password'], 'required', 'message' => 'Es necesario este campo'],
                [['old_password','password','confirm_password'], 'string', 'min' => 6],
                ['confirm_password', 'compare', 'compareAttribute' => 'password'],
            ];
        }
      /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'password' => 'Nueva contraseña',
            'confirm_password' => 'Repetir la nueva contraseña',
            'old_password' => 'Contraseña actual'

        ];
        
    }
        /**
         * Changes password.
         *
         * @return boolean if password was changed.
         */
        public function changePassword()
        {
            
            $user = $this->_user;
            if(Yii::$app->security->validatePassword($this->old_password, $user->password_hash)){
                $user->setPassword($this->password);
                return $user->save(false);
            
            }
            
        }
        
    }