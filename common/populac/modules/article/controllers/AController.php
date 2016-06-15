<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-16 上午11:25
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\populac\modules\article\controllers;

use common\populac\components\CategoryController;

class AController extends CategoryController
{
    /** @var string  */
    public $categoryClass = 'common\populac\modules\article\models\Category';

    /** @var string  */
    public $moduleName = 'article';
}