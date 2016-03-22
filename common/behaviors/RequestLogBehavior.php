<?php
/**
 * RequestLogBehavior.php
 * ==============================================
 * 版权所有 2001-2015 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-3-18
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\behaviors;

use common\models\RequestLog;
use Yii;
use yii\base\Behavior;
use yii\web\Application;

class RequestLogBehavior extends Behavior
{
    /**
     * @var array: 例外的规则
     */
    public $excludeRules = [];

    /**
     * @inheritDoc
     */
    public function events()
    {
        $exclude = false;
        foreach($this->excludeRules as $excludeRule)
        {
            if(call_user_func($excludeRule)) {
                $exclude = true;
                break;
            }
        }
        return $exclude ? [] : [Application::EVENT_AFTER_REQUEST => 'afterRequest'];
    }


    /**
     * (void) afterRequest :
     * @param $event
     */
    public function afterRequest($event)
    {
        $request = new RequestLog();
        $request->save();
    }

}