<?php

namespace common\modules\preferences\models;

use Yii;

/**
 * This is the model class for table "preferences".
 *
 * @property string $codes
 * @property string $name1
 * @property integer $changemark
 * @property string $classmark
 * @property integer $id
 * @property string $classmarkcn
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Preferences extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'preferences';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codes', 'name1', 'classmark', 'classmarkcn', 'created_at', 'updated_at'], 'required'],
            [['changemark', 'status', 'created_at', 'updated_at'], 'integer'],
            [['codes', 'classmark'], 'string', 'max' => 10],
            [['name1'], 'string', 'max' => 80],
            [['classmarkcn'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'codes' => '参数编码',
            'name1' => '参数名称',
            'changemark' => '修改标识',
            'classmark' => '项目分类-英文',
            'id' => '自增ID',
            'classmarkcn' => '项目分类-中文',
            'status' => '是否启用',
            'created_at' => '新增时间',
            'updated_at' => '修改时间',
        ];
    }
}
