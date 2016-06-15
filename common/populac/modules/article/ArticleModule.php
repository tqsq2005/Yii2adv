<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-16 上午9:19
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\populac\modules\article;

use common\populac\components\Module;

class ArticleModule extends Module
{
    public $settings = [
        'categoryThumb' => true,
        'articleThumb' => true,
        'enablePhotos' => true,

        'enableShort' => true,
        'shortMaxLength' => 255,
        'enableTags' => true,

        'itemsInFolder' => false,
    ];

    public static $installConfig = [
        'title' => [
            'en' => 'Articles',
            'zh-CN' => '文章管理',
        ],
        'icon' => 'pencil',
        'order_num' => 65,
    ];
}