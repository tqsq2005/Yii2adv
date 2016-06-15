<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-18 下午10:33
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\populac\widgets;

use Yii;
use yii\base\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\Json;

use common\populac\assets\FancyboxAsset;

class Fancybox extends Widget
{
    public $options = [];
    public $selector;

    public function init()
    {
        parent::init();

        if (empty($this->selector)) {
            throw new InvalidConfigException('Required `selector` param isn\'t set.');
        }
    }

    public function run()
    {
        $clientOptions = (count($this->options)) ? Json::encode($this->options) : '';

        $this->view->registerAssetBundle(FancyboxAsset::className());
        $this->view->registerJs('$("'.$this->selector.'").fancybox('.$clientOptions.');');
    }
}