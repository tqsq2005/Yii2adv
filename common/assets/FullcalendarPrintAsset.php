<?php

namespace common\assets;

use yii\web\AssetBundle;

class FullcalendarPrintAsset extends AssetBundle
{
    /**
     * [$sourcePath description]
     * @var string
     */
    public $sourcePath = '@common/static/plus/fullcalendar/';
    
    /**
     * [$css description]
     * @var array
     */
    public $css = [
        'fullcalendar.print.css'
    ];

    /**
     * options for the css file beeing published
     * @var [type]
     */
    public $cssOptions = [
    	'media' => 'print'
    ];
}

