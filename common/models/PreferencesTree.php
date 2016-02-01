<?php
/**
  * Preferences.php
  * ==============================================
  * 版权所有 2001-2015 http://www.zhmax.com
  * ----------------------------------------------
  * 这不是一个自由软件，未经授权不许任何使用和传播。
  * ----------------------------------------------
  * @date: 16-1-12
  * @author: LocoRoco<tqsq2005@gmail.com>
  * @version:v2016
  * @since:Yii2
  * ----------------------------------------------
  * 程序文件简介：
  * ==============================================
  */

namespace common\models;

use kartik\tree\models\Tree;
use Yii;

class PreferencesTree extends Tree {
    /**
     * @inheritdoc
     * (string) tableName :
     * @static
     * @return string
     */
    public static function tableName()
    {
        return '{{%preferencesTree}}';
    }

    /**
     * @inheritdoc
     * (array) rules :
     * @return array
     */
    public function rules()
    {
        $rules      = parent::rules();
        $rules[]    = [['codes', 'name1', 'classmark'], 'safe'];
        return $rules;
    }
}