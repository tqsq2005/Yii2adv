<?php

/**
 * TrailsLog.php
 * ==============================================
 * 版权所有 2001-2015 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-4-26
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\widgets;


use yii\base\Widget;

class TrailsLog extends Widget
{
    /**
     * @inheritDoc
     */
    public function run()
    {
        return $this->render('trails-log');
    }

}