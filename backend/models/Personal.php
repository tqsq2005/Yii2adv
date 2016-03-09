<?php

namespace backend\models;

use Yii;

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
 *
 * @property Marry[] $marries
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
            [['childnum', 'selfno', 'logout'], 'integer'],
            [['personal_id'], 'required'],
            [['code1'], 'string', 'max' => 36],
            [['name1', 'tel', 'whcd', 'is_dy', 'title', 'zw', 'ltman', 'lttel', 'cardcode', 'do_man'], 'string', 'max' => 50],
            [['sex', 'mz', 'marry', 'hkxz', 'work1', 'obect1', 'flag', 'memo1', 'onlysign', 'cztype', 'incity', 'checktime'], 'string', 'max' => 2],
            [['birthdate', 'marrydate', 'postcode', 'jobdate', 'ingoingdate', 'lhdate', 'zhdate', 'ltpostcode', 'carddate', 'examinedate', 'feeddate', 'yzdate', 's_date', 'e_date', 'marrowdate', 'leavedate', 'audittime'], 'string', 'max' => 10],
            [['fcode'], 'string', 'max' => 18],
            [['address1', 'hkaddr', 'ltunit', 'ltaddr', 'fzdw', 'checkunit'], 'string', 'max' => 80],
            [['grous', 'unit', 'oldunit'], 'string', 'max' => 30],
            [['picture_name', 'memo2'], 'string', 'max' => 100],
            [['memo'], 'string', 'max' => 254],
            [['personal_id'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code1' => '员工编码',
            'name1' => '姓名',
            'sex' => '性别',
            'birthdate' => '出生日期',
            'fcode' => '身份证号',
            'mz' => 'Mz',
            'marry' => 'Marry',
            'marrydate' => 'Marrydate',
            'address1' => 'Address1',
            'hkaddr' => 'Hkaddr',
            'tel' => 'Tel',
            'postcode' => 'Postcode',
            'hkxz' => 'Hkxz',
            'work1' => 'Work1',
            'whcd' => 'Whcd',
            'is_dy' => 'Is Dy',
            'title' => 'Title',
            'zw' => 'Zw',
            'grous' => 'Grous',
            'obect1' => 'Obect1',
            'flag' => 'Flag',
            'childnum' => 'Childnum',
            'unit' => 'Unit',
            'jobdate' => 'Jobdate',
            'ingoingdate' => 'Ingoingdate',
            'memo1' => 'Memo1',
            'lhdate' => 'Lhdate',
            'zhdate' => 'Zhdate',
            'picture_name' => 'Picture Name',
            'onlysign' => 'Onlysign',
            'selfno' => 'Selfno',
            'ltunit' => 'Ltunit',
            'ltaddr' => 'Ltaddr',
            'ltman' => 'Ltman',
            'lttel' => 'Lttel',
            'ltpostcode' => 'Ltpostcode',
            'memo' => 'Memo',
            'cztype' => 'Cztype',
            'carddate' => 'Carddate',
            'examinedate' => 'Examinedate',
            'cardcode' => 'Cardcode',
            'fzdw' => 'Fzdw',
            'feeddate' => 'Feeddate',
            'yzdate' => 'Yzdate',
            'checkunit' => 'Checkunit',
            'incity' => 'Incity',
            'memo2' => 'Memo2',
            's_date' => '登记日期',
            'logout' => 'Logout',
            'e_date' => 'E Date',
            'personal_id' => 'Personal ID',
            'do_man' => 'Do Man',
            'marrowdate' => 'Marrowdate',
            'oldunit' => 'Oldunit',
            'leavedate' => 'Leavedate',
            'checktime' => 'Checktime',
            'audittime' => 'Audittime',
            'id' => 'ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarries()
    {
        return $this->hasMany(Marry::className(), ['personal_id' => 'personal_id']);
    }

    /**
     * (int|string) getMarriesCount : 计算配偶个数
     * @return int|string
     */
    public function getMarriesCount()
    {
        return $this->hasMany(Marry::className(), ['personal_id' => 'personal_id'])->count();
    }
}
