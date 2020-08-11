<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use frontend\models\ChangeEmailForm;
use frontend\models\ContactForm;
use common\events\MailEvent;
use common\models\ValorHelpers;
use common\models\User;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','change-password'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','change-password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
          /*  'error' => [
                'class' => 'yii\web\ErrorAction',
                //'layout' => 'main'
                //'view' => '@app/views/site/error.php',
            ],*/
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            
            if(ValorHelpers::estadoCoincide('VerificarEmail') && $exception instanceof yii\web\ForbiddenHttpException) {
                Yii::$app->session->setFlash('info',
                 '<p>Lamentamos molestarlo, </p>
                 <p>Para que pueda recibir notificaciones deberá indicar y verificar su casilla de correo electrónico (Email).</p>
                 <p> A continuación rellene el formulario, recibirá un correo a la casilla indicada para verificarlo.</p>');

                Yii::$app->user->identity->email = '';
                return $this->redirect(['change-email']);
            }
            $error = $this->formatError($exception);
            return $this->render('error',['message' => $error]);
        }
    }
    protected function formatError($exception){
        $message=$exception->getMessage();
        $classException = get_class($exception);
        switch($classException){
            case "yii\web\ForbiddenHttpException":
                $message = "No tiene permiso para esta operación";
                break;
            case "yii\web\NotFoundHttpException":
                $message = "No se pudo encontrar el sitio que buscaba";
                break;
        }
        return $message;        
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        //$this->layout = "portal";
        
        //$event->ejecutar();
        //$event->on(MailEvent::EVENT_SEND,'sendMessage','hola');
        
        //enviar un mail
        /*try {
        \Yii::$app
            ->mailer
            ->compose(
            )
            ->setFrom(getenv("SMTP_USER"))
            ->setTo("njmdistrisoft@gmail.com")
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
        } catch(\Swift_TransportException $e){
            return $this->render('index');
        }*/
        return $this->render('index');
    }


    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionAyuda()
    {
        return $this->render('ayuda');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            
            if(Yii::$app->user->identity->estado_id == ValorHelpers::getEstadoId('VerificarEmail')){
                Yii::$app->session->setFlash('info',
                 '<p>Lamentamos molestarlo, </p>
                 <p>Para que pueda recibir notificaciones deberá indicar y verificar su casilla de correo electrónico (Email).</p>
                 <p> A continuación rellene el formulario, recibirá un correo a la casilla indicada para verificarlo.</p>');

                Yii::$app->user->identity->email = '';
                /*return $this->render('changeEmail', [
                    'model' => Yii::$app->user->identity,
                ]);*/
                return $this->redirect(['change-email']);
            }
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
     /**
     * Change User password.
     *
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionChangePassword()
    {
        $id = \Yii::$app->user->id;
     
        try {
            $model = new \frontend\models\ChangePasswordForm($id);
        } catch (InvalidParamException $e) {
            throw new \yii\web\BadRequestHttpException($e->getMessage());
        }
     
        if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->changePassword()) {
            \Yii::$app->session->setFlash('success', '¡La contraseña ha sido cambiada!');
        }
     
        return $this->render('changePassword', [
            'model' => $model,
        ]);
    }
    public function actionChangeEmail(){
        $id = \Yii::$app->user->id;
        $model = new ChangeEmailForm($id);
        if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->changeEmail()) {
            \Yii::$app->session->setFlash('success', '<p>¡El Email ha sido cambiado! </p><p>Debe verificar el mismo para continuar</p>');
            return $this->redirect(['index']);
        }
        return $this->render('changeEmail', [
            'model' => $model,
        ]);
    }

      /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Su correo electrónico (email) ha sido verificado con éxito!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Lo lamentamos, no se ha podido confirmar el correo electrónico. Intente nuevamente generando un nuevo enlace.');
        return $this->goHome();
    }
  
    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Yii::$app->session->setFlash('info','Si usted ha ingresado correctamente el email, se le enviará un mensaje a su bandeja de entrada.');
            //intentar enviar email
            $model->sendEmail();
            /*if ($model->sendEmail()) {
                //Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }*/
            return $this->goHome();
            //Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
            

        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}
