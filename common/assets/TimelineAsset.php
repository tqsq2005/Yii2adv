<?php

namespace common\assets;

use yii\web\AssetBundle;

class TimelineAsset extends AssetBundle
{
    public $sourcePath = '@common/static/plus/TimelineJS3/compiled/';
    public $css = [
        'css/timeline.css'
    ];
    public $js = [
        'js/timeline-min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'common\assets\IEhack',
    ];
}