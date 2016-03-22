<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "reminders".
 *
 * @property integer $id
 * @property integer $event_id
 * @property string $title
 * @property integer $offset
 * @property integer $time
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Events $event
 */
class Reminders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reminders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'title', 'offset', 'time'], 'required'],
            [['event_id', 'offset', 'time', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            TimestampBehavior::className(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增ID',
            'event_id' => '事件ID',
            'title' => '提醒标题',
            'offset' => 'UTC偏移',
            'time' => '触发提醒时间',
            'created_at' => '提醒创建时间',
            'updated_at' => '提醒更新时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Events::className(), ['id' => 'event_id']);
    }
}
