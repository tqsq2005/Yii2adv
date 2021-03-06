<?php
/**
  * Test.php
  * ==============================================
  * 版权所有 2001-2015 http://www.zhmax.com
  * ----------------------------------------------
  * 这不是一个自由软件，未经授权不许任何使用和传播。
  * ----------------------------------------------
  * @date: 16-1-28
  * @author: LocoRoco<tqsq2005@gmail.com>
  * @version:v2016
  * @since:Yii2
  * ----------------------------------------------
  * 程序文件简介：
  * ==============================================
  */

namespace backend\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

class TestController extends Controller {

    public function actionIndex()
    {
        echo 'My test action! <br>';
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function afterAction($action, $result)
    {
        echo 'before action<br>';
        echo 'test<br>';
        return parent::afterAction($action, $result); // TODO: Change the autogenerated stub
    }

    public function beforeAction($action)
    {
        echo 'after action<br>';
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

}