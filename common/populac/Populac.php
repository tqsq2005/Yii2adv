<?php

namespace common\populac;

use Yii;
use common\populac\models\Module;
use yii\web\ServerErrorHttpException;

/**
 * populac module definition class
 */
class Populac extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'common\populac\controllers';
    public $settings;
    public $activeModules;
    //public $controllerLayout = '@easyii/views/layouts/main';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        parent::init();

        if(Yii::$app->cache === null){
            throw new ServerErrorHttpException('请在配置文件中配置cache组件！');
        }

        $this->activeModules = Module::findAllActive();

        $modules = [];
        foreach($this->activeModules as $name => $module){
            $modules[$name]['class'] = $module->class;
            if(is_array($module->settings)){
                $modules[$name]['settings'] = $module->settings;
            }
        }
        $this->setModules($modules);

        //define('IS_ROOT',  !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin);
        //define('LIVE_EDIT', !Yii::$app->user->isGuest && Yii::$app->session->get('easyii_live_edit'));
        //后台登录的都算为ROOT
        define('IS_ROOT',  !Yii::$app->user->isGuest && Yii::$app->homeUrl != '/');
        define('LIVE_EDIT', !Yii::$app->user->isGuest && Yii::$app->session->get('easyii_live_edit'));
    }
}
