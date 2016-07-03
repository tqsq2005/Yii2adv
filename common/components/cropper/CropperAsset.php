<?php

namespace common\components\cropper;

use yii\web\AssetBundle;

/**
 * CropperAsset
 *
 * @url https://github.com/fengyuanchen/cropper
 * @author LocoRoco <tqsq2005@gmail.com>
 */
class CropperAsset extends AssetBundle
{
    public $sourcePath = '@common/static/plus/cropper/dist';
    public $css = [
        'cropper.min.css',
    ];
    public $js = [
        'cropper.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
