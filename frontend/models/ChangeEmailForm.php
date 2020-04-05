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
class ChangeEmailForm extends \yii\db\ActiveRecord
{
        public $id;
        public $email;
        public $email_confirm;
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
                [['email'], 'required', 'message' => 'Es necesario este campo'],
                [['email'], 'string', 'min' => 6],
                //['confirm_password', 'compare', 'compareAttribute' => 'password'],
            ];
        }
      /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Email',

        ];
        
    }

    public function changeEmail() {
        $user = $this->_user;
        $user->setEmail($this->email);
        $setMail = $user->save(false);
        if($setMail){
            Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                    ['user' => $user]
                )
                ->setFrom(getenv("SMTP_USER"))
                ->setTo($this->email)
                ->setSubject('Account registration at ' . Yii::$app->name)
                ->send();
        }
        return $setMail;
    }
   
}