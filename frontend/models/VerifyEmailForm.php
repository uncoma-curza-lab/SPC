<?php

namespace frontend\models;

use common\models\User;
use common\models\ValorHelpers;
use yii\base\InvalidArgumentException;
use yii\base\Model;

class VerifyEmailForm extends Model
{
    /**
     * @var string
     */
    public $token;

    /**
     * @var User
     */
    private $_user;


    /**
     * Creates a form model with given token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws InvalidArgumentException if token is empty or not valid
     */
    public function __construct($token, array $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Proporcione el código de verificación.');
        }
        $this->_user = User::findByVerificationToken($token);
        if (!$this->_user) {
            throw new InvalidArgumentException('El código proporcionado no es correcto.');
        }
        parent::__construct($config);
    }
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['estado_id' => Estado::find()->where(['or',['estado_nombre' => 'Pendiente'],['estado_nombre' => 'VerificarEmail']])->one()->id],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }


    /**
     * Verify email
     *
     * @return User|null the saved model or null if saving fails
     */
    public function verifyEmail()
    {
        $user = $this->_user;
        $user->estado_id = ValorHelpers::getEstadoId('Activo');
        $user->verification_email_token = null;
        return $user->save(false) ? $user : null;
    }
}

