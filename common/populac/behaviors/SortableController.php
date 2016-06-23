<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-13 下午4:27
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\populac\behaviors;

use Yii;
use yii\base\Behavior;

class SortableController extends Behavior
{
    public $model;//类名
    public $ordercol = 'order_num';//排序字段名

    public function move($id, $direction, $condition = [])
    {
        $ordercol   = $this->ordercol;
        $modelClass = $this->model;
        $success = '';
        if (($model = $modelClass::findOne($id))) {
            if ($direction === 'up') {
                $eq = '>';
                $orderDir = 'ASC';
            } else {
                $eq = '<';
                $orderDir = 'DESC';
            }

            $query = $modelClass::find()->orderBy("$ordercol " . $orderDir)->limit(1);

            $where = [$eq, $ordercol, $model->$ordercol];
            if (count($condition)) {
                $where = ['and', $where];
                foreach ($condition as $key => $value) {
                    $where[] = [$key => $value];
                }
            }
            $modelSwap = $query->where($where)->one();

            if (!empty($modelSwap)) {
                $newOrderNum = $modelSwap->$ordercol;

                $modelSwap->$ordercol = $model->$ordercol;
                $modelSwap->update();

                $model->$ordercol = $newOrderNum;
                $model->update();

                $success = ['swap_id' => $modelSwap->primaryKey];
            }
        } else {
            $this->owner->error = 'Not found';
        }

        return $this->owner->formatResponse($success);
    }
}