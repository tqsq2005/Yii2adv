<?php
/**
  * JquerySlimScroll.php
  * ==============================================
  * 版权所有 2001-2015 http://www.zhmax.com
  * ----------------------------------------------
  * 这不是一个自由软件，未经授权不许任何使用和传播。
  * ----------------------------------------------
  * @date: 16-1-8
  * @author: LocoRoco<tqsq2005@gmail.com>
  * @version:v2016
  * @since:Yii2
  * ----------------------------------------------
  * 程序文件简介：
  * ==============================================
  */

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Class JquerySlimScroll : http://rocha.la/jQuery-slimScroll
 * @package common\assets
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @since:Yii2
 */
class JquerySlimScroll extends AssetBundle {
    public $sourcePath = '@bower/jquery-slimscroll';
    public $js = [
        'jquery.slimscroll.min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}