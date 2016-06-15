<?php

/**
 * Event.php
 * ==============================================
 * 版权所有 2001-2015 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-4-11
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace backend\models;


//use bedezign\yii2\audit\AuditTrailBehavior;
use common\behaviors\ARLogBehavior;
use dektrium\user\models\User;
//use mootensai\behaviors\UUIDBehavior;
//use mootensai\relation\RelationTrait;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "event".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $allDay
 * @property integer $start
 * @property integer $end
 * @property string $dow
 * @property string $url
 * @property string $className
 * @property integer $editable
 * @property integer $startEditable
 * @property integer $durationEditable
 * @property string $source
 * @property string $color
 * @property string $backgroundColor
 * @property string $borderColor
 * @property string $textColor
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property User $createdBy
 */
class Event extends ActiveRecord
{
    //use RelationTrait;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['allDay', 'editable', 'startEditable', 'durationEditable', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['start', 'end'], 'default', 'value' => date('Y-m-d H:i:s')],
            [['start', 'end'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            //[['start', 'end'], 'safe'],
            [['title'], 'string', 'max' => 200],
            [['description'], 'string', 'max' => 400],
            [['dow'], 'string', 'max' => 20],
            [['url', 'className', 'source'], 'string', 'max' => 50],
            [['color', 'backgroundColor', 'borderColor', 'textColor'], 'string', 'max' => 20],
            [['allDay', 'editable', 'startEditable', 'durationEditable'], 'boolean'],
            [['editable', 'startEditable', 'durationEditable'], 'default', 'value' => '1'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
            ],
            'audit' => [
                'class' => ARLogBehavior::className(),
            ],
            /*'uuid' => [
                'class' =>UUIDBehavior::className(),
                'column' => 'id',
            ],*/
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '事件标题',
            'description' => '事件内容',
            'allDay' => '是否整天',
            'start' => '开始时间',
            'end' => '结束时间',
            'dow' => '星期几重复',
            'url' => '点击时访问的URL',
            'className' => 'Class Name',
            'editable' => '是否可修改',
            'startEditable' => '开始时间可修改',
            'durationEditable' => '结束时间可修改',
            'source' => 'Source',
            'color' => '整体颜色',
            'backgroundColor' => '背景颜色',
            'borderColor' => '边框颜色',
            'textColor' => '字体颜色',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

}