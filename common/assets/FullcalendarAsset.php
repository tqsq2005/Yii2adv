<?php

namespace common\assets;

use Yii;
use yii\web\AssetBundle;


class FullcalendarAsset extends AssetBundle
{
    /**
     * [$sourcePath description]
     * @var string
     */
    public $sourcePath = '@common/static/plus/fullcalendar/';

    /**
     * the language the calender will be displayed in
     * @var string ISO2 code for the wished display language
     */
    public $language = NULL;

    /**
     * [$autoGenerate description]
     * @var boolean
     */
    public $autoGenerate = true;

    /**
     * tell the calendar, if you like to render google calendar events within the view
     * @var boolean
     */
    public $googleCalendar = false;
    
    /**
     * [$css description]
     * @var array
     */
    public $css = [
        'fullcalendar.min.css'
    ];

    /**
     * [$js description]
     * @var array
     */
    public $js = [
        'lib/moment.min.js',
        'fullcalendar.min.js',
        'lang-all.js'
    ];
    
    /**
     * [$depends description]
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\jui\JuiAsset',//JUI 风格
        //'common\assets\EasyuiAsset',//j-easyui 风格  http://www.yiichina.com/code/77
        'common\assets\FullcalendarPrintAsset'
    ];

    /**
     * @inheritdoc
     */
    public function registerAssetFiles($view)
    {
        $language = $this->language ? $this->language : Yii::$app->language;
        if ($language != 'en-us') 
        {
            $this->js[] = "lang/{$language}.js";
        }

        if($this->googleCalendar)
        {
            $this->js[] = 'gcal.js';
        }

        parent::registerAssetFiles($view);
    }

}
