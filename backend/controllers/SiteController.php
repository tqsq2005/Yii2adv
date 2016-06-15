<?php
namespace backend\controllers;

use common\populac\helpers\Data;
use common\traits\AjaxValidationTrait;
use dosamigos\qrcode\QrCode;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\Controller;
//use common\models\LoginForm;
use dektrium\user\models\LoginForm;
use yii\filters\VerbFilter;
use yii\web\ViewAction;

/**
 * Site controller
 */
class SiteController extends Controller
{
    use AjaxValidationTrait;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
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
            //验证码
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength' => 1,//验证码最小长度
                'maxLength' => 4,//验证码最大长度
                'fontFile' => '@yii/captcha/BOTTF.TTF',//验证码字体库
                'offset' => 2,//验证码字符间距
            ],
            //icon
            'icon' => [
                'class' => ViewAction::className(),
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        /*if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }*/
        if (!Yii::$app->user->isGuest) {
            $this->goHome();
        }

        /** @var LoginForm $model */
        $model = Yii::createObject(LoginForm::className());

        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', [
            'model'  => $model,
            'module' => $this->module,
        ]);
    }

    public function actionLogout()
    {
        /*Yii::$app->user->logout();

        return $this->goHome();*/
        Yii::$app->getUser()->logout();

        return $this->goHome();
    }

    /**
     * (void) actionQrcode : 生成指定的网址二维码
     * @param string $url
     */
    public function actionQrcode($url = '')
    {
        return QrCode::png($url);
    }

    public function actionTest()
    {
        return $this->render('test');
    }

    public function actionTest2()
    {
        $type = 'backend';
        $assetPath = ($type === 'backend') ? Yii::$app->assetManager->basePath : str_replace('backend', 'frontend', Yii::$app->assetManager->basePath);
        foreach(glob($assetPath . DIRECTORY_SEPARATOR . '*') as $asset){
            echo $asset . '<br>';
        }
    }
}
