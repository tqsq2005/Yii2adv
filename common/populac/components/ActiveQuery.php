<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-13 下午3:12
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\populac\components;

/**
 * Base active query class for models
 * @package common\populac\components
 */
class ActiveQuery extends \yii\db\ActiveQuery
{
    /**
     * Apply condition by status
     * @param $status
     * @return $this
     */
    public function status($status)
    {
        $this->andWhere(['status' => (int)$status]);
        return $this;
    }

    /**
     * Order by primary key DESC
     * @return $this
     */
    public function desc()
    {
        $model = $this->modelClass;
        $this->orderBy([$model::primaryKey()[0] => SORT_DESC]);
        return $this;
    }

    /**
     * Order by primary key ASC
     * @return $this
     */
    public function asc()
    {
        $model = $this->modelClass;
        $this->orderBy([$model::primaryKey()[0] => SORT_ASC]);
        return $this;
    }

    /**
     * Order by order_num
     * @return $this
     */
    public function sort()
    {
        $this->orderBy(['order_num' => SORT_DESC]);
        return $this;
    }

    /**
     * Order by date
     * @return $this
     */
    public function sortDate()
    {
        $this->orderBy(['time' => SORT_DESC]);
        return $this;
    }
}