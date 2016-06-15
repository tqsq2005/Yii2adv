<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-23 上午11:56
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 15/12/13
 * Time: 上午10:51.
 */
namespace common\widgets\danmu;

use yii\helpers\Url;

class Danmu extends \yii\base\Widget
{
    public $id;
    public $listUrl = null;
    public $comment_type = 'article';
    public function init()
    {
        parent::init();
        $this->listUrl = $this->listUrl ?: Url::to(['/comment/dm', 'comment_type' => $this->comment_type]);
    }
    public function run()
    {
        DanmuAsset::register($this->view);
        $script = "initDm({$this->id}, '{$this->listUrl}');";
        $this->view->registerJs($script);
    }
}
