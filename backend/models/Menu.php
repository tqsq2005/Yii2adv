<?php

/**
 * Menu.php
 * ==============================================
 * 版权所有 2001-2015 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-4-27
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace backend\models;


use common\behaviors\ARLogBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class Menu extends \mdm\admin\models\Menu
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'audit' => [
                'class' => ARLogBehavior::className(),
            ],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function beforeSave($insert)
    {
        //新增有上级单位名称没有上级编码
        if( $insert && $this->parent_name && !$this->parent ) {
            $query = self::findOne(['name' => $this->parent_name]);
            if( $query ) {
                $this->parent = $query->id;
            } else {
                return false;
            }
        }
        return parent::beforeSave($insert);
    }

    public function getChildren($id)
    {
        $query = $this::find();
        $query->select([
            'id',
            'text'      => 'name',
            'data',
        ]);
        $query->andFilterWhere([
            'parent' => $id,
        ]);
        $data = $query->orderBy(['order' => SORT_ASC])->asArray()->all();
        if(count($data) > 0) {
            foreach($data as &$arr) {
                $arr['children']    = $this->isParent($arr['id']);
                $arr['icon']        = $arr['data'];
                $arr['url']         = Url::to(['detail', 'id' => $arr['id']]);
            }
        }
        return $data;
    }

    public function isParent($id)
    {
        $query = $this::find()->andFilterWhere([
            'parent' => $id,
        ])->count(1);

        if($query > 0) {
            return true;
        }

        return false;
    }
}