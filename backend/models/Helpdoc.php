<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%helpdoc}}".
 *
 * @property integer $id
 * @property string $author
 * @property string $title
 * @property string $content
 * @property integer $status
 * @property integer $upid
 * @property integer $created_at
 * @property integer $updated_at
 */
class Helpdoc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%helpdoc}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author', 'title', 'content', 'status', 'upid', 'created_at', 'updated_at'], 'required'],
            [['content'], 'string'],
            [['status', 'upid', 'created_at', 'updated_at'], 'integer'],
            [['author'], 'string', 'max' => 30],
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
            'author' => '作者',
            'title' => '标题',
            'content' => '内容',
            'status' => '是否启用',
            'upid' => '上级ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
