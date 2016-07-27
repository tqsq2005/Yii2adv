<?php

namespace common\models;

use bedezign\yii2\audit\models\AuditTrail;
use common\behaviors\ARLogBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

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
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
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
            [['code1', 'marrow', 'because', 'becausedate', 'mfcode', 'mhkdz', 'marrowdate', 'marrowunit', 'othertel', 'hfp', 'maddr', 'mpostcode', 'marrowno', 'hmarry'], 'required'],
            [['id', 'marrowno', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [
                ['becausedate', 'marrowdate'],
                'date',
                'format' => 'php:Ymd',
                'message' => '日期格式：YYYYMMDD'
            ],
            [['code1'], 'string', 'max' => 36],
            [['marrow', 'othertel', 'marrycode', 'do_man'], 'string', 'max' => 50],
            [['because', 'hfp', 'hmarry'], 'string', 'max' => 2],
            [['becausedate', 'marrowdate', 'mpostcode'], 'string', 'max' => 10],
            [['mfcode'], 'string', 'max' => 18, 'min' => 15],
            [['mhkdz', 'marrowunit', 'maddr'], 'string', 'max' => 80],
            [['mem'], 'string', 'max' => 100],
            [['unit'], 'string', 'max' => 30],
            [['personal_id'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
            'blame' => [
                'class' => BlameableBehavior::className(),
            ],
            'ARLog' => [
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
            'id' => 'ID',
            'code1' => '员工编号',
            'marrow' => '配偶姓名',
            'because' => '与员工婚姻关系',
            'becausedate' => '发生婚姻关系时间',
            'mfcode' => '配偶身份证号',
            'mhkdz' => '配偶户口地址',
            'marrowdate' => '配偶出生日期',
            'marrowunit' => '配偶工作单位',
            'othertel' => '配偶单位电话',
            'hfp' => '配偶户口性质',
            'maddr' => '配偶单位地址',
            'mpostcode' => '配偶单位邮编',
            'marrowno' => '配偶生育次数',
            'hmarry' => '配偶婚姻状况',
            'marrycode' => '结婚证号',
            'mem' => '备注',
            'unit' => '单位编码',
            'personal_id' => '员工PID',
            'do_man' => 'Do Man',
            'mid' => '主键ID',
            'created_by' => '添加者',
            'updated_by' => '末次修改者',
            'created_at' => '添加时间',
            'updated_at' => '末次修改时间',
        ];
    }

    /**
     * (int) generateId : 返回最大id
     * @static
     * @param $pid
     * @return int
     */
    public static function generateId( $pid )
    {
        $query = self::find()
            ->where(['personal_id' => $pid])
            ->max('id');

        return $query ? intval($query) + 1 : 1;
    }

    /**
     * ($this)  getAuditTrails : get trails for this model
     * @return  $this
     */
    public function getAuditTrails()
    {
        return $this->hasMany(AuditTrail::className(), ['model_id' => 'mid'])
            ->andOnCondition(['REGEXP', 'field', '^\[(.)*\]$'])
            ->andOnCondition(['model' => get_class($this)]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonal()
    {
        return $this->hasOne(Personal::className(), ['personal_id' => 'personal_id']);
    }

    
}
