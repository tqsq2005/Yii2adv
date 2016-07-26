<?php

namespace common\models;

use common\behaviors\ARLogBehavior;
use common\populac\models\Preferences;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "personal".
 *
 * @property string $code1
 * @property string $name1
 * @property string $sex
 * @property string $birthdate
 * @property string $fcode
 * @property string $mz
 * @property string $marry
 * @property string $marrydate
 * @property string $address1
 * @property string $hkaddr
 * @property string $tel
 * @property string $postcode
 * @property string $hkxz
 * @property string $work1
 * @property string $whcd
 * @property string $is_dy
 * @property string $title
 * @property string $zw
 * @property string $grous
 * @property string $obect1
 * @property string $flag
 * @property integer $childnum
 * @property string $unit
 * @property string $jobdate
 * @property string $ingoingdate
 * @property string $memo1
 * @property string $lhdate
 * @property string $zhdate
 * @property string $picture_name
 * @property string $onlysign
 * @property integer $selfno
 * @property string $ltunit
 * @property string $ltaddr
 * @property string $ltman
 * @property string $lttel
 * @property string $ltpostcode
 * @property string $memo
 * @property string $cztype
 * @property string $carddate
 * @property string $examinedate
 * @property string $cardcode
 * @property string $fzdw
 * @property string $feeddate
 * @property string $yzdate
 * @property string $checkunit
 * @property string $incity
 * @property string $memo2
 * @property string $s_date
 * @property integer $logout
 * @property string $e_date
 * @property string $personal_id
 * @property string $do_man
 * @property string $marrowdate
 * @property string $oldunit
 * @property string $leavedate
 * @property string $checktime
 * @property string $audittime
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $fhdate
 *
 * @property Marry[] $marries
 * @property Unit $unit0
 */
class Personal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'personal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code1', 'name1', 'sex', 'birthdate', 'fcode', 'marry', 'unit',
                's_date', 'flag', 'memo1', 'selfno', 'childnum', 'mz', 'work1', 'ingoingdate',
                'address1', 'hkaddr', 'hkxz', 'e_date', 'checktime'], 'required'],
            [['marrydate'], 'required',
                'when' => function($model) {
                    return $model->marry != '10';
                }, 'whenClient' => "function (attribute, value) {
                    return $('#p-marry').val() != '10';
                }"
            ],
            [['lhdate'], 'required',
                'when' => function($model) {
                    return in_array($model->marry, [Preferences::getCodesByName1('pmarry', '离婚'), Preferences::getCodesByName1('pmarry', '再婚'),Preferences::getCodesByName1('pmarry', '复婚')]);
                }, 'whenClient' => "function (attribute, value) {
                    return $.inArray($('#p-marry').val(), ['22', '23', '40']) > -1 ;
                }"
            ],
            [['zhdate'], 'required',
                'when' => function($model) {
                    return $model->marry == '22';
                }, 'whenClient' => "function (attribute, value) {
                    return $('#p-marry').val() == '22';
                }"
            ],
            [['fhdate'], 'required',
                'when' => function($model) {
                    return $model->marry == '23';
                }, 'whenClient' => "function (attribute, value) {
                    return $('#p-marry').val() == '23';
                }"
            ],
            [
                ['s_date', 'birthdate', 'ingoingdate', 'jobdate', 'marrydate', 'lhdate', 'zhdate', 'fhdate'],
                'date',
                'format' => 'php:Ymd',
                'message' => '日期格式：YYYYMMDD'
            ],
            [['e_date'], 'number'],
            [['childnum', 'selfno', 'logout', 'checktime', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['code1'], 'string', 'max' => 36],
            [['name1', 'tel', 'whcd', 'is_dy', 'title', 'zw', 'ltman', 'lttel', 'cardcode', 'do_man'], 'string', 'max' => 50],
            [['sex', 'mz', 'marry', 'hkxz', 'work1', 'obect1', 'flag', 'memo1', 'onlysign', 'cztype', 'incity'], 'string', 'max' => 2],
            [['birthdate', 'marrydate', 'postcode', 'jobdate', 'ingoingdate', 'lhdate', 'zhdate', 'fhdate', 'ltpostcode', 'carddate', 'examinedate', 'feeddate', 'yzdate', 's_date', 'e_date', 'marrowdate', 'leavedate', 'audittime'], 'string', 'max' => 8],
            [['fcode'], 'string', 'max' => 18, 'min' => 15],
            [['address1', 'hkaddr', 'ltunit', 'ltaddr', 'fzdw', 'checkunit'], 'string', 'max' => 80],
            [['grous', 'unit', 'oldunit'], 'string', 'max' => 30],
            [['picture_name', 'memo2'], 'string', 'max' => 100],
            [['memo'], 'string', 'max' => 254],
            [['personal_id'], 'string', 'max' => 60],
            [['personal_id'], 'unique'],
            [['unit'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::className(), 'targetAttribute' => ['unit' => 'unitcode']],
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
            'code1' => '员工编号',
            'name1' => '姓名',
            'sex' => '性别',
            'birthdate' => '出生日期',
            'fcode' => '身份证号',
            'mz' => '民族',
            'marry' => '婚姻状况',
            'marrydate' => '初婚日期',
            'address1' => '现住地址',
            'hkaddr' => '户口地址',
            'tel' => '联系电话',
            'postcode' => '邮政编码',
            'hkxz' => '户口性质',
            'work1' => '编制',
            'whcd' => '文化程度',
            'is_dy' => '政治面貌',
            'title' => '职称',
            'zw' => '职务',
            'grous' => '所属街道',
            'obect1' => '重点对象',
            'flag' => '户籍性质',
            'childnum' => '现子女数',
            'unit' => '所在部门',
            'jobdate' => '工作日期',
            'ingoingdate' => '入单位日期',
            'memo1' => '管理对象',
            'lhdate' => '离婚日期',
            'zhdate' => '再婚日期',
            'picture_name' => 'Picture Name',
            'onlysign' => '是否独生',
            'selfno' => '生育次数',
            'ltunit' => '单位名称',
            'ltaddr' => '单位地址',
            'ltman' => '联系人',
            'lttel' => '联系电话',
            'ltpostcode' => '邮政编码',
            'memo' => '备注',
            'cztype' => '婚育证类型',
            'carddate' => '领证日期',
            'examinedate' => '到期日期',
            'cardcode' => '证明号码',
            'fzdw' => '发证单位',
            'feeddate' => '流入日期',
            'yzdate' => '验证日期',
            'checkunit' => '验证单位',
            'incity' => '配偶同来',
            'memo2' => '备注',
            's_date' => '登记日期',
            'logout' => '注销原因',
            'e_date' => '注销日期',
            'personal_id' => 'Personal ID',
            'do_man' => 'Do Man',
            'marrowdate' => 'Marrowdate',
            'oldunit' => 'Oldunit',
            'leavedate' => 'Leavedate',
            'checktime' => '函调/妇检次数',
            'audittime' => 'Audittime',
            'id' => 'ID',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'fhdate' => '复婚日期',
        ];
    }

    /**
     * (string) getMaxCode : 返回最大code1
     * `select code1 from personal WHERE code1 REGEXP '^[0-9]+$'  ORDER BY code1 DESC LIMIT 1;`
     * @static
     * @return string
     */
    public static function getMaxCode()
    {
        $query = self::find()->select(['code1'])
            ->where([
                'REGEXP', 'code1', '^[0-9]+$'
            ])->orderBy([
                'code1' => SORT_DESC
            ])->limit(1)->one();

        if($query) {
            return str_pad($query->code1 + 1, 6, '0', STR_PAD_LEFT);
        } else {
            return '000001';
        }
    }

    /**
     * (string) generatePersonal_id : 生成personal_id
     * @static
     * @param $unit 部门编码
     * @param int $randomStrLength 随机字符串长度
     * @return string personal_id
     */
    public static function generatePersonal_id( $unit, $randomStrLength = 12 )
    {
        $security   = Yii::$app->security;
        if ( $unit == '%' ) $unit = $security->generateRandomString(8);
        $randomStr  = $security->generateRandomString($randomStrLength);
        return date('YmdHis') . $randomStr . $unit;
    }

    /**
     * (null|static) getPersonalByPid : 返回personal_id对应的Personal实例
     * @static
     * @param string $pid personal_id
     * @return null|static
     */
    public static function getPersonalByPid( $pid )
    {
        $data = self::findOne(['personal_id' => $pid]);
        return $data ? $data : null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarries()
    {
        return $this->hasMany(Marry::className(), ['personal_id' => 'personal_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['unitcode' => 'unit']);
    }
}
