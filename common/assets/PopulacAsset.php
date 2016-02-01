<?php
/**
  * PopulacAsset.php
  * ==============================================
  * 版权所有 2001-2015 http://www.zhmax.com
  * ----------------------------------------------
  * 这不是一个自由软件，未经授权不许任何使用和传播。
  * ----------------------------------------------
  * @date: 16-1-13
  * @author: LocoRoco<tqsq2005@gmail.com>
  * @version:v2016
  * @since:Yii2
  * ----------------------------------------------
  * 程序文件简介：
  * ==============================================
  */

namespace common\assets;

use Yii;
use yii\web\AssetBundle;

class PopulacAsset extends AssetBundle{
    public $sourcePath = '@common/static';
    public $js = [
        //'js/bootstrap.min.js',
        //layer组件 http://layer.layui.com/
        'js/layer/layer.js',
        // jquery-UI
        //'js/jquery-ui/jquery-ui-1.10.0.custom.min.js',
        //'js/jquery-ui/jquery-ui.zh-CN.js',
        //backstretch 背景更换组件
        'js/jquery.backstretch.min.js',
        //cookie 组件
        'js/jquery.cookie.js',
        //moment 组件，时间比较 http://momentjs.com/
        //'js/moment.min.js',
        //'js/moment-with-locales.min.js',
        //工作计划组件
        //'js/fullcalendar.min.js',
        //表格排序
        //'js/jquery.dataTables.min.js',
        //可以 搜索的 select
        //'js/chosen.jquery.min.js',
        //'js/jquery.colorbox-min.js',
        //'js/jquery.noty.js',//消息通知组件
        //'js/responsive-tables.js',
        'js/bootstrap-tour.min.js',
        //'js/jquery.raty.min.js',
        //'js/jquery.iphone.toggle.js',
        //'js/jquery.autogrow-textarea.js',
        //'js/jquery.uploadify-3.1.min.js',
        //'js/jquery.history.js',
        //'js/charisma.js',
        'js/app/common.js',
        'js/qrcode.js',//二维码
    ];
    public $css = [
        //'css/bootstrap-cerulean.min.css',
        //'css/fullcalendar.css',
        //'css/fullcalendar.print.css',
        //'css/chosen.min.css',
        //'css/colorbox.css',
        //'css/responsive-tables.css',
        'css/bootstrap-tour.min.css',
        //'css/jquery.noty.css',
        //'css/noty_theme_default.css',
        //'css/elfinder.min.css',
        //'css/elfinder.theme.css',
        //'css/jquery.iphone.toggle.css',
        //'css/uploadify.css',
        'css/animate.min.css',
        //'css/charisma-app.css',
        //'js/jquery-ui/jquery-ui-1.10.0.custom.css',
        'css/qrcode.css',//二维码
    ];

    public $depends = [
        'common\assets\IEhack',//IE8以下hack
        'common\assets\JquerySlimScroll',//jquery-slimscroll
    ];
}