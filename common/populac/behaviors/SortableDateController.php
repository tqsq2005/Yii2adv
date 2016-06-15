<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-16 上午11:39
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

class SortableDateController extends Behavior
{
    public $model;

    public function move($id, $direction, $condition = [])
    {
        $modelClass = $this->model;
        $success = '';
        if(($model = $modelClass::findOne($id))){
            if($direction === 'up'){
                $eq = '>';
                $orderDir = 'ASC';
            } else {
                $eq = '<';
                $orderDir = 'DESC';
            }

            $query = $modelClass::find()->orderBy('time '.$orderDir)->limit(1);

            $where = [$eq, 'time', $model->time];
            if(count($condition)){
                $where = ['and', $where];
                foreach($condition as $key => $value){
                    $where[] = [$key => $value];
                }
            }
            $modelSwap = $query->where($where)->one();

            if(!empty($modelSwap))
            {
                $newOrderNum = $modelSwap->time;

                $modelSwap->time = $model->time;
                $modelSwap->update();

                $model->time = $newOrderNum;
                $model->update();

                $success = ['swap_id' => $modelSwap->primaryKey];
            }
        }
        else{
            $this->owner->error = Yii::t('easyii', 'Not found');
        }

        return $this->owner->formatResponse($success);
    }
}