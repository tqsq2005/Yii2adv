<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-12 上午8:43
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\assets;


use yii\web\AssetBundle;
//http://www.yiichina.com/code/77
class EasyuiAsset extends AssetBundle
{
    public $sourcePath = '@common/static/plus/easyui-fullcalendar/';
    public $css = [
        'themes/default/easyui.css'
    ];
    public $js = [
        'jquery.easyui.min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}