<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-7-8 上午11:47
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

/**
 * DataTableAsset.php
 * ==============================================
 * 版权所有 2001-2015 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-4-22
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\assets;


use yii\web\AssetBundle;

class DataTableEditorNoPDFAsset extends AssetBundle
{
    public $sourcePath = '@common/static/plus/DataTables-editor/';
    public $css = [
        'css/editor.bootstrap.min.css'
    ];
    public $js = [
        'js/dataTables.editor.min.js',
        'js/editor.bootstrap.min.js'
    ];
    public $depends = [
        'common\assets\DataTableNoPDFAsset'
    ];

}