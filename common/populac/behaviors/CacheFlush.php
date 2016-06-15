<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-13 下午2:57
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\populac\behaviors;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Behavior;

/**
 * CacheFlush behavior
 * @package common\populac\behaviors
 * @inheritdoc
 */
class CacheFlush extends Behavior
{
    /** @var  string */
    public $key;

    public function attach($owner)
    {
        parent::attach($owner);

        if(!$this->key) $this->key = constant(get_class($owner).'::CACHE_KEY');
    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'flush',
            ActiveRecord::EVENT_AFTER_UPDATE => 'flush',
            ActiveRecord::EVENT_AFTER_DELETE => 'flush',
        ];
    }

    /**
     * Flush cache
     */
    public function flush()
    {
        if($this->key) {
            if(is_array($this->key)){
                foreach($this->key as $key){
                    Yii::$app->cache->delete($key);
                }
            } else {
                Yii::$app->cache->delete($this->key);
            }
        }
        else{
            Yii::$app->cache->flush();
        }
    }
}