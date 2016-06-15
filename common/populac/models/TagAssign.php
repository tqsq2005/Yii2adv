<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-16 上午10:45
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\populac\models;

use common\populac\components\ActiveRecord;

/**
 * This is the model class for table "{{%tag_assign}}".
 *
 * @property string $class
 * @property integer $item_id
 * @property integer $tag_id
 */
class TagAssign extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%tag_assign}}';
    }
}