<?php

namespace common\assets;

use yii\web\AssetBundle;

class JqueryContextMenu extends AssetBundle
{
    public $sourcePath = '@common/static/plus/jQuery-contextMenu/dist/';
    public $css = [
        'jquery.contextMenu.min.css'
    ];
    public $js = [
        'jquery.contextMenu.min.js',
        'jquery.ui.position.min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}