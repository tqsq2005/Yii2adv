<?php

namespace backend\models;

use common\behaviors\ARLogBehavior;
use common\behaviors\Taggable;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%helpdoc}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $status
 * @property integer $upid
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $created_by
 * @property string $updated_by
 *
 * @property HelpdocTag[] $helpdocTags
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
            [['title', 'content', 'status', 'upid'], 'required'],
            [['content'], 'string'],
            [['status', 'upid', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['created_by', 'updated_by'], 'string', 'max' => 30],
            [['tagNames'], 'safe'],
        ];
    }

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
            ],
            'taggable'  => [
                'class' => Taggable::className(),
            ],
            'audit' => [
                'class' => ARLogBehavior::className(),
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增ID',
            'title' => '标题',
            'content' => '内容',
            'status' => '是否启用',
            'upid' => '上级标题',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => '作者',
            'updated_by' => '修改人员',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getHelpdocTags()
    {
        return $this->hasMany(HelpdocTag::className(), ['helpdoc_id' => 'id']);
    }*/

    /**
     * ($this) getTags :
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('{{%helpdoc_tag}}', ['helpdoc_id' => 'id']);
    }
}
