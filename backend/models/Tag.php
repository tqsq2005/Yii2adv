<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%tag}}".
 *
 * @property integer $id
 * @property integer $frequency
 * @property string $name
 *
 * @property HelpdocTag[] $helpdocTags
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['frequency'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'frequency' => '使用频率',
            'name' => '标签名',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHelpdocTags()
    {
        return $this->hasMany(HelpdocTag::className(), ['tag_id' => 'id']);
    }

    public static function findAllByName($name)
    {
        return self::find()->andFilterWhere(['like', 'name', $name])->all();
    }
}
