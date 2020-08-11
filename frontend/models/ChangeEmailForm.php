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
use common\models\Estado;
use yii\imagine\Image;
use common\models\ValorHelpers;

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
                [['email'], function($attribute,$params){
                    $estadoActivoID = Estado::find()->where(['=','estado_nombre','Activo'])->one()->id;
                    return User::find()->where(['=','estado_id',$estadoActivoID])->andWhere(['=','email',$this->$attribute ])->one() ?  
                        $this->addError($attribute,'El email ingresado está siendo utilizado por otro usuario.') : 
                        true;
                }
                    //'targetClass' => '\common\models\User',
                    //'filter' => ['estado_id' => Estado::find()->where(['=','estado_nombre','Activo'])->one()->id],
                    //'filter' => ['email' => User::find()->where(['=','email',])]
                    //'message' => 'There is no user with this email address.'
                ],
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
        $user->estado_id = ValorHelpers::getEstadoId('Activo');
        $user->verification_email_token = null;
        return $user->save(false) ? $user : null;

        /* SE COMENTA PARA SOLUCIONAR PROBLEMATICA DE EMAILS TARDE
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
                ->setSubject('Verificación de correo de ' . Yii::$app->name)
                ->send();
        }
        return $setMail;*/
    }
   
}