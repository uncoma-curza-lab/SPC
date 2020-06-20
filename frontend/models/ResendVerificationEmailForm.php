<?php


namespace frontend\models;
use common\models\Estado;
use Yii;
use common\models\User;
use yii\base\Model;

class ResendVerificationEmailForm extends Model
{
    /**
     * @var string
     */
    public $email;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required','message' => 'Debe completar el correo'],
            ['email', 'email', 'message' => 'El formato del correo no es correcto.'],
            /*['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['estado_id' => Estado::find()->where(['=','estado_nombre','VerificarEmail'])->one()->id],
                //'message' => 'There is no user with this email address.'
            ],*/
        ];
    }

    /**
     * Sends confirmation email to user
     *
     * @return bool whether the email was sent
     */
    public function sendEmail()
    {
        $user = User::find()->where([
            'email' => $this->email,
            
        ])->andWhere(['or',
        [
            'estado_id' => Estado::find()->where(['=','estado_nombre','VerificarEmail'])->one()->id
        ],
        [
            'estado_id' => Estado::find()->Where(['=','estado_nombre','Pendiente'])->one()->id
        ]])->one();

        if ($user === null) {
            return false;
        }

        $user->generateEmailVerificationToken();
        if ($user->save(false))
        {
            return Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                    ['user' => $user]
                )
                ->setFrom(getenv("SMTP_USER"))
                ->setTo($this->email)
                ->setSubject('Verificación de correo electrónico ' . Yii::$app->name)
                ->send();
        } else {
            return false;
        }
    }
}