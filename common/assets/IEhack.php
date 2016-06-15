<?php
/**
  * IEhack.php
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
 * Class Html5shiv : 低版本IE的时候加载html5shiv.min.js
 * @package common\assets
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @since:Yii2
 */
class IEhack extends AssetBundle {
    public $sourcePath = '@common/static/app';
    public $js = [
        'js/html5shiv.min.js',
        'js/respond.min.js',
    ];

    public $jsOptions = [
        'condition'=>'lt IE 9',
        'position' => \yii\web\View::POS_HEAD,
    ];
}