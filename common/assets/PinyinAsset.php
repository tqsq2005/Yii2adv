<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-23 上午8:53
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
 * Class PinyinAsset : 汉字转拼音的jquery插件
 * @package common\assets
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @since:Yii2
 */
class PinyinAsset extends AssetBundle
{
    public $sourcePath = '@common/static/plus/jquery-pinyin';
    public $js = [
        'jQuery.Hz2Py-min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}