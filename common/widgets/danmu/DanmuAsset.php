<?php
/**
 * author: yidashi
 * Date: 2015/12/4
 * Time: 17:18.
 */
namespace common\widgets\danmu;

use yii\web\AssetBundle;

class DanmuAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/danmu/assets';
    public $css = [
        'css/dm.css',
    ];
    public $js = [
        'js/dm_util.min.js',
        'js/dm.js',
        'js/danmuManager.js',
        'js/hjz.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
