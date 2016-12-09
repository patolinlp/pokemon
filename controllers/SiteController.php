<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\Session;
use app\models\FormRecoverPass;
use app\models\FormResetPass;
use app\models\MisUser;
use yii\helpers\Url;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                // 'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionRecoverpass()
    {
        $model = new FormRecoverPass;
        $msg = null;

        if ($model->load(Yii::$app->request->post()))
        {
        if ($model->validate())
        {
        $table = MisUser::find()->where(["email" => $model->email]);
        if ($table->count() == 1)
        {
        $session = new Session;
        $session->open();
        $session["recover"] = $this->randKey("abcdef0123456789", 200);
        $recover = $session["recover"];
        $table = MisUser::find()->where(["email" => $model->email])->one();
        $session["id_recover"] = $table->id;

        $verification_code = $this->randKey("abcdef0123456789", 8);
        $table->verification_code = $verification_code;
        $table->save();

        $subject = "Recuperar password";
        $body = "<p>Copie el siguiente código de verificación para restablecer su password ... ";
        $body .= "<strong>".$verification_code."</strong></p>";
        $body .= "<p><a href='http://localhost/basic/web/index.php?r=site/resetpass'>Recuperar password</a></p>";
        Yii::$app->mailer->compose()
            ->setTo($model->email)
            ->setFrom ("no-responder@sflores.cl")
            ->setSubject($subject)
            ->setHtmlBody($body)
            ->send();

        $model->email = null;
        $msg = "Le hemos enviado un mensaje a su cuenta de correo para que
        pueda resetear su password";
        }
        else
        {
        $msg = "Ha ocurrido un error";
        }
        }
        else
        {
        $model->getErrors();
        }
        }
        return $this->render("recoverpass", ["model" => $model, "msg" => $msg]);
        }
    
    public function actionResetpass()
    {
     $model = new FormResetPass;
     $msg = null;
     $session = new Session;
     $session->open();
     if (empty($session["recover"]) || empty($session["id_recover"])){
     return $this->redirect(["site/index"]);
     }
     else{
     $recover = $session["recover"];
     $model->recover = $recover;
     $id_recover = $session["id_recover"];
     }
     if ($model->load(Yii::$app->request->post())){
     if ($model->validate()){
     if ($recover == $model->recover){
    $table = MisUser::findOne(["email" => $model->email, "id" => $id_recover, "verification_code" => $model->verification_code]);
     $table->password = MisUser::hashPassword($model->password);
     if ($table->save()){
     $session->destroy();
     $model->email = null;
     $model->password = null;
     $model->password_repeat = null;
     $model->recover = null;
     $model->verification_code = null;

     $msg = "Enhorabuena, password reseteado correctamente";
     $msg .= "<meta http-equiv='refresh' content='5;".Url::to("index.php?r=site/login")."'>";
     }
     else{
     $msg = "Ha ocurrido un error";
     }
     }
     else{
     $model->getErrors();
     }
     }
     }
     return $this->render("resetpass", ["model" => $model, "msg" => $msg]);
    }
    private function    randkey($str='',    $long=0)
    {
        $key    =   null;
        $str    =   str_split($str);
        $start  =   0;
        $limit  =   count($str)-1;
        for($x=0    ;$x<$long;$x++)
        {
         $key   .=  $str[rand($start,$limit)];
        }
        return  $key;
    }

}
