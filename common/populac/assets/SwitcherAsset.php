<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-17 上午8:15
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\populac\assets;

class SwitcherAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower/jquery.switcher/dist';
    public $depends = ['yii\web\JqueryAsset'];

    public function init()
    {
        if (YII_DEBUG) {
            $this->js[] = 'switcher.js';
            $this->css[] = 'switcher.css';
        } else {
            $this->js[] = 'switcher.min.js';
            $this->css[] = 'switcher.min.css';
        }
    }
}