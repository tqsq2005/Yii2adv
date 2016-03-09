<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%preferences}}".
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
    const CHANGEMARK_DEFAULT    = 1;
    const STATUS_ACTIVE         = 1;
    const STATUS_INVALID        = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%preferences}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codes', 'name1', 'classmark', 'classmarkcn'], 'required'],
            [['changemark', 'status', 'created_at', 'updated_at'], 'integer'],
            [['codes'], 'string', 'max' => 4],
            [['name1'], 'string', 'max' => 80],
            [['classmark'], 'string', 'max' => 30],
            [['classmarkcn'], 'string', 'max' => 50],
            [['changemark'], 'default', 'value' => self::CHANGEMARK_DEFAULT],
            [['status'], 'default', 'value' => self::STATUS_ACTIVE],
            [['status'], 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INVALID]]
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

    /**
     * @return int
     */
    public function getStatusOptions()
    {
        return [
            self::STATUS_ACTIVE     => '启用',
            self::STATUS_INVALID    => '禁用',
        ];
    }

    /**
     * (mixed) getName1Text : 根据给定的项目分类的英文名称及其参数代码返回参数名称
     * @param $classmark 项目分类的英文名称
     * @param $codes 参数代码
     * @return mix 参数名称
     */
    public static function getName1Text($classmark, $codes)
    {
        $name1 = self::findOne([
            'status'    => self::STATUS_ACTIVE,
            'classmark' => $classmark,
            'codes'     => $codes,
        ])->name1;
        return $name1;
    }

    public static function getClassmarkcnByClassmark($classmark = '')
    {
        $model = self::find()->andFilterWhere(['classmark' => $classmark])->one();
        if($model)
            return $model->classmarkcn;
        return '';
    }
}
