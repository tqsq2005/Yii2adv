<?php

namespace common\models;

use common\behaviors\ARLogBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "unit".
 *
 * @property string $unitcode
 * @property string $unitname
 * @property string $corporation
 * @property string $address1
 * @property string $office
 * @property string $oname
 * @property string $tel
 * @property string $fax
 * @property string $unitkind
 * @property string $rank
 * @property integer $corpflag
 * @property string $rsystem
 * @property string $upunitname
 * @property string $upunitcode
 * @property string $postcode
 * @property string $char1
 * @property string $date1
 * @property string $leader
 * @property string $leadertel
 * @property string $jsxzdate
 * @property string $jsxhdate
 * @property string $jsbdate
 * @property integer $id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 */
class Unit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'unit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unitcode', 'unitname', 'upunitcode'], 'required'],
            [['corpflag', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['unitcode', 'upunitcode'], 'string', 'max' => 30],
            [['unitname', 'address1', 'office', 'rsystem', 'upunitname'], 'string', 'max' => 80],
            [['corporation', 'oname', 'tel', 'fax', 'leader', 'leadertel'], 'string', 'max' => 50],
            [['unitkind', 'date1', 'jsxzdate', 'jsxhdate', 'jsbdate'], 'string', 'max' => 10],
            [['rank'], 'string', 'max' => 2],
            [['postcode', 'char1'], 'string', 'max' => 20],
            [['unitcode'], 'unique'],
            [['upunitcode'], 'exist', 'targetAttribute' => 'unitcode'],
            [['upunitname'], 'exist', 'targetAttribute' => 'unitname'],
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
            'unitcode' => '单位编码',
            'unitname' => '单位名称',
            'corporation' => '法人代表',
            'address1' => '通讯地址',
            'office' => '所属街道',
            'oname' => '专干姓名',
            'tel' => '专干联系电话',
            'fax' => '传真',
            'unitkind' => '单位性质',
            'rank' => '是否为下属单位',
            'corpflag' => '类型',
            'rsystem' => '所属厅级',
            'upunitname' => '主管单位名称',
            'upunitcode' => '主管单位编码',
            'postcode' => '邮政编码',
            'char1' => 'Char1',
            'date1' => '人事姓名',
            'leader' => '党政一把手',
            'leadertel' => '党政联系电话',
            'jsxzdate' => 'Jsxzdate',
            'jsxhdate' => 'Jsxhdate',
            'jsbdate' => 'Jsbdate',
            'id' => 'ID',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * (array|\yii\db\ActiveRecord[]) getChildren : 获取下级信息
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getChildren($id)
    {
        $query = $this::find();
        $query->select([
            'id'    => 'unitcode',
            'text'  => 'unitname',
        ]);
        $query->andFilterWhere([
            'upunitcode' => ($id == '0') ? '%' : $id,
        ]);
        $data = $query->orderBy(['unitcode' => SORT_ASC])->asArray()->all();
        if(count($data) > 0) {
            foreach($data as &$arr) {
                $arr['children']    = $this->isParent($arr['id']);
                $arr['icon']        = $arr['children'] ? 'fa fa-folder-o text-success' : 'fa fa-star-half-o text-success';
                $arr['id']          = ($arr['id'] == '%') ? '0' : $arr['id'];
                $arr['url']         = Url::to(['detail', 'id' => $arr['id']]);
            }
        }
        return $data;
    }

    /**
     * (bool) isParent : 判断是否有下级
     * @param $id
     * @return bool
     */
    public function isParent($id)
    {
        $query = $this::find()->andFilterWhere([
            'upunitcode' => $id,
        ])->count(1);

        if($query > 0) {
            return true;
        }

        return false;
    }

    /**
     * (string) getMaxunitcode : 新增单位用到，获取给定单位编码最大的下属编码
     * @param $unitcode
     * @return string
     */
    public static function getMaxunitcode($unitcode)
    {
        $query = self::find();
        $maxunitcode = $query->where([
            'upunitcode' => ($unitcode == '0') ? '%' : $unitcode,
        ])->max('unitcode');
        if($maxunitcode) {
            $unitcode   = ($unitcode == '0' || $unitcode == '%') ? substr($maxunitcode, 0, -2) : $unitcode;
            return $unitcode . substr($maxunitcode+1, -2);
        }
        return $unitcode . '01';
    }

    /**
     * (false|null|string) getChildList : 返回所有下级单位，包含自身
     * @static
     * @param $unitcode
     * @return false|null|string
     */
    public static function getChildList($unitcode)
    {
        return Yii::$app->db->createCommand('select getChildList(:unitcode)')
            ->bindValue(':unitcode', $unitcode)->queryScalar();
    }

    /**
     * (false|null|string) getChildList : 返回所有主管单位，不包含自身
     * @static
     * @param $unitcode
     * @return false|null|string
     */
    public static function getParentList($unitcode)
    {
        return Yii::$app->db->createCommand('select getParentList(:unitcode)')
            ->bindValue(':unitcode', $unitcode)->queryScalar();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonals()
    {
        return $this->hasMany(Personal::className(), ['unit' => 'unitcode']);
    }
}
