<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-6-2 上午10:15
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
 * Class FloatTheadAsset : Asset bundle for floatThead
 * @package common\assets
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @since:Yii2
 */
class FloatTheadAsset extends AssetBundle
{
    public $sourcePath = '@common/static/plus/jquery-floatThead/dist';

    public $js = ['jquery.floatThead.min.js'];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}