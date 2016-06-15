<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-18 下午10:31
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
use common\populac\models\Photo;

class Photos extends Widget
{
    public $model;

    public function init()
    {
        parent::init();

        if (empty($this->model)) {
            throw new InvalidConfigException('Required `model` param isn\'t set.');
        }
    }

    public function run()
    {
        $photos = Photo::find()->where(['class' => get_class($this->model), 'item_id' => $this->model->primaryKey])->sort()->all();
        echo $this->render('photos', [
            'photos' => $photos
        ]);
    }

}