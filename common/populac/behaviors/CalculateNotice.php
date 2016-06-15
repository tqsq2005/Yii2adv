<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-6-6 下午2:07
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\populac\behaviors;

use Yii;
use yii\db\ActiveRecord;
use common\populac\models\Module;

class CalculateNotice extends \yii\base\Behavior
{
    public $callback;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'updateNotice',
            ActiveRecord::EVENT_AFTER_UPDATE => 'updateNotice',
            ActiveRecord::EVENT_AFTER_DELETE => 'updateNotice',
        ];
    }

    public function updateNotice()
    {
        $moduleName = \common\populac\components\Module::getModuleName(get_class($this->owner));
        if(($module = Module::findOne(['name' => $moduleName]))){
            $module->notice = call_user_func($this->callback);
            $module->update();
        }
    }
}