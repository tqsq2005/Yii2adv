<?php

namespace common\models;

use bedezign\yii2\audit\AuditTrailBehavior;
use dektrium\user\models\User;
use nhkey\arh\ActiveRecordHistoryBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "events".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $data
 * @property integer $time
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 * @property Reminders[] $reminders
 */
class Events extends \yii\db\ActiveRecord
{
    public $lastOldAttributes = [];
    public $lastDirtyAttributes = [];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'events';
    }

    /**
     * (array) behaviors :
     * @return array
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
            /*'history' => [
                'class' => ActiveRecordHistoryBehavior::className(),
            ],*/
            'audit' => [
                'class' => AuditTrailBehavior::className(),
            ],
        ]);
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'title'], 'required'],
            [['user_id', 'time', 'created_at', 'updated_at'], 'integer'],
            [['user_id',], 'filter', 'filter' => 'intval'],
            [['data'], 'string'],
            [['title'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增ID',
            'user_id' => '用户ID',
            'title' => '事件标题',
            'data' => '事件内容',
            'time' => '触发事件时间',
            'created_at' => '事件创建时间',
            'updated_at' => '事件更新时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReminders()
    {
        return $this->hasMany(Reminders::className(), ['event_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        $this->lastOldAttributes = $this->oldAttributes;
        $this->lastDirtyAttributes = $this->dirtyAttributes;
        return parent::beforeSave($insert);
    }

    public function beforeDelete()
    {
        $this->lastOldAttributes = $this->oldAttributes;
        $this->lastDirtyAttributes = $this->lastDirtyAttributes;
        return parent::beforeDelete();
    }


}
