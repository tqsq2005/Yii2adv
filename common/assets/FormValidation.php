<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-25 下午5:09
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\assets;


use yii\web\AssetBundle;

class FormValidation extends AssetBundle
{
    public $sourcePath = '@common/static/plus/formValidation/';
    public $css = [
        'css/formValidation.min.css'
    ];
    public $js = [
        'js/formValidation.min.js',
        'js/framework/bootstrap.min.js',
        'js/language/zh_CN.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}