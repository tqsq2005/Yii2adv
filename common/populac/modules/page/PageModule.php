<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-23 上午10:05
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\populac\modules\page;

use Yii;

class PageModule extends \common\populac\components\Module
{
    public static $installConfig = [
        'title' => [
            'en' => 'Pages',
            'zh-CN' => '单页模板',
        ],
        'icon' => 'file',
        'order_num' => 50,
    ];
}