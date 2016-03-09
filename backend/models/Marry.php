<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "marry".
 *
 * @property integer $id
 * @property string $code1
 * @property string $marrow
 * @property string $because
 * @property string $becausedate
 * @property string $mfcode
 * @property string $mhkdz
 * @property string $marrowdate
 * @property string $marrowunit
 * @property string $othertel
 * @property string $hfp
 * @property string $maddr
 * @property string $mpostcode
 * @property integer $marrowno
 * @property string $hmarry
 * @property string $marrycode
 * @property string $mem
 * @property string $unit
 * @property string $personal_id
 * @property string $do_man
 * @property integer $mid
 *
 * @property Personal $personal
 */
class Marry extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'marry';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'personal_id'], 'required'],
            [['id', 'marrowno'], 'integer'],
            [['code1'], 'string', 'max' => 36],
            [['marrow', 'othertel', 'marrycode', 'do_man'], 'string', 'max' => 50],
            [['because', 'hfp', 'hmarry'], 'string', 'max' => 2],
            [['becausedate', 'marrowdate', 'mpostcode'], 'string', 'max' => 10],
            [['mfcode'], 'string', 'max' => 18],
            [['mhkdz', 'marrowunit', 'maddr'], 'string', 'max' => 80],
            [['mem'], 'string', 'max' => 100],
            [['unit'], 'string', 'max' => 30],
            [['personal_id'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code1' => 'Code1',
            'marrow' => '配偶姓名',
            'because' => '婚姻状况',
            'becausedate' => '发生婚姻关系时间',
            'mfcode' => '身份证号',
            'mhkdz' => 'Mhkdz',
            'marrowdate' => '出生日期',
            'marrowunit' => 'Marrowunit',
            'othertel' => 'Othertel',
            'hfp' => 'Hfp',
            'maddr' => 'Maddr',
            'mpostcode' => 'Mpostcode',
            'marrowno' => 'Marrowno',
            'hmarry' => 'Hmarry',
            'marrycode' => 'Marrycode',
            'mem' => 'Mem',
            'unit' => 'Unit',
            'personal_id' => 'Personal ID',
            'do_man' => 'Do Man',
            'mid' => 'Mid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonal()
    {
        return $this->hasOne(Personal::className(), ['personal_id' => 'personal_id']);
    }
}
