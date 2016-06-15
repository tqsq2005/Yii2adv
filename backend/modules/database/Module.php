<?php

namespace backend\modules\database;

/**
 * Class Module : 数据库备份与恢复模块
 * @package backend\modules\database
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @since:Yii2
 */
class Module extends \yii\base\Module
{
    public function init()
    {
        parent::init();
        \Yii::configure($this, require(__DIR__ . '/config/main.php'));
    }
}