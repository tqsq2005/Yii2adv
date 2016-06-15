<?php

namespace common\assets;

use yii\web\AssetBundle;

class Qtip extends AssetBundle
{
    public $sourcePath = '@common/static/plus/jquery-qtip/';
    public $css = [
        'jquery.qtip.min.css'
    ];
    public $js = [
        'jquery.qtip.js',
        'imagesloaded.pkgd.min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}