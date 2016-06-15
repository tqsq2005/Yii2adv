<?php

namespace common\populac\controllers;

use common\populac\models\Preferences;
use Yii;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\web\Controller;

/**
 * Default controller for the `populac` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect(['modules/index']);
    }

    public function actionTest()
    {
        /*$name1 = Preferences::get('psex', '01');
        echo $name1;
        echo Preferences::get('psex', '02');
        //var_dump(Preferences::get('pmarry', '01'));
        echo Preferences::get('pmarry', '10');
        echo Preferences::get('cpsystem', '10');*/
        //var_dump(Preferences::set('sStatus', '0', '禁用', '状态'));
        //Preferences::set('sStatus', '0', '禁用', '状态');
        //Preferences::set('sSystem', 'appname', '计生管理系统', '系统信息');
        echo Yii::$app->request->baseUrl;
        var_dump(IS_ROOT);
    }
}
