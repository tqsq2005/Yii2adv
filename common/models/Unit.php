<?php

namespace common\models;

use common\behaviors\ARLogBehavior;
use common\components\validators\UnitAccessible;
use common\populac\behaviors\SortableModel;
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
 * @property integer $ver
 * @property integer $order_num
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 */
class Unit extends \yii\db\ActiveRecord
{
    /** @var string $_delUnitcode 要删除的单位编码 */
    private $_delUnitcode;
    /** @var string $_delUpunitcode 要删除的主管单位编码 */
    private $_delUpunitcode;
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
            [['corpflag', 'ver', 'order_num', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['unitcode', 'upunitcode'], 'string', 'max' => 30],
            [['unitname', 'address1', 'office', 'rsystem', 'upunitname'], 'string', 'max' => 80],
            [['corporation', 'oname', 'tel', 'fax', 'leader', 'leadertel'], 'string', 'max' => 50],
            [['unitkind', 'date1', 'jsxzdate', 'jsxhdate', 'jsbdate'], 'string', 'max' => 10],
            [['rank'], 'string', 'max' => 2],
            [['postcode', 'char1'], 'string', 'max' => 20],
            [['unitcode'], 'unique'],
            [['upunitcode'], 'exist', 'targetAttribute' => 'unitcode'],
            [['upunitname'], 'exist', 'targetAttribute' => 'unitname'],
            [['unitcode', 'upunitcode'], UnitAccessible::className()],
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
            'sortable' => [
                'class' => SortableModel::className(),//auto create column [ order_num ] 's value
            ],
        ]);
    }

    /**
     * @inheritDoc
     * Make Unit support optimistic lock, with the field of ver.
     */
    public function optimisticLock()
    {
        return 'ver';
    }

    /**
     * @inheritDoc
     */
    public function beforeDelete()
    {
        //删除之前先赋值unitcode给$_delUnitcode
        $this->_delUnitcode = $this->unitcode;
        return parent::beforeDelete();
    }

    /**
     * @inheritDoc
     */
    public function beforeSave($insert)
    {
        //先赋值旧的unitcode  给$_delUnitcode
        //  赋值旧的upunitcode给$_delUpunitcode
        $this->_delUnitcode     = $this->getOldAttribute('unitcode');
        $this->_delUpunitcode   = $this->getOldAttribute('upunitcode');
        return parent::beforeSave($insert);
    }

    /**
     * @inheritDoc
     */
    public function afterDelete()
    {
        parent::afterDelete();
        //TODO: 后期要继续添加 删除人员、配偶等等相关联表的代码 deleteAll不触发事件，需要记录的用delete()
        //删除map_unit表中unitcode是：$_delUnitcode 的
        MapUnit::deleteAll(['unitcode' => $this->_delUnitcode]);
    }

    /**
     * @inheritDoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        //新增操作记得更新map_unit权限
        if( $insert ) {
            //只要对新增单位的主管单位权限不小于当前用户的都应该授权为 完全访问
            /** @var integer $user_id 当前用户ID */
            $user_id    = Yii::$app->user->identity->id;
            /** @var string $unitcode 新增的单位编码 */
            $unitcode   = $this->unitcode;
            /** @var string $upunitcode 新增的主管单位编码 */
            $upunitcode = $this->upunitcode;
            /** @var integer $permission 符合条件的用户都设置为 完全访问 */
            $permission = MapUnit::USER_POWER_ALLOW;
            $SQL        = "REPLACE INTO `map_unit`(user_id, unitcode, user_power) ".
                " SELECT mp.user_id, '{$unitcode}', {$permission} FROM (SELECT `user_id`, `unitcode`, `user_power` FROM `map_unit` WHERE `unitcode` = :upunitcode) mp ".
                " JOIN (SELECT `user_id`, `unitcode`, `user_power` FROM `map_unit` WHERE `user_id` = :user_id AND `unitcode` = :upunitcode) cur_mp ".
                " ON mp.unitcode = cur_mp.unitcode AND mp.user_power >= cur_mp.user_power ";
            Yii::$app->db->createCommand( $SQL )
                ->bindValues([
                    ':upunitcode'   => $upunitcode,
                    ':user_id'      => $user_id,
                ])
                ->execute();
        } else {
            //更新操作就相应更新关联表
            //TODO: 后期要继续添加 删除人员、配偶等等相关联表的代码 updateAll不触发事件，需要记录的用update()
            if(array_key_exists('unitcode', $changedAttributes)) {
                MapUnit::updateAll(['unitcode' => $this->unitcode], ['unitcode' => $this->_delUnitcode]);
            }
        }
    }

    /**
     * @inheritDoc
     * Make update and delete operations transactional.
     */
    public function transactions()
    {
        return [
            self::OP_UPDATE | self::OP_DELETE,
        ];
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
            'ver' => '乐观锁标记',
            'order_num' => '排序',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * (array|\yii\db\ActiveRecord[]) getChildren : 根据用户权限获取下级信息
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getChildren($id)
    {
        $user_id = Yii::$app->user->identity->id;
        $data = Unit::find()
            ->select([
                'id'    => 'unit.unitcode',
                'text'  => 'unit.unitname',
            ])
            ->innerJoin('map_unit', '`map_unit`.`unitcode` = `unit`.`unitcode`')
            ->andFilterWhere([
                'map_unit.user_id' => $user_id
            ])
            ->andFilterWhere([
                'unit.upunitcode' => ($id == '0') ? '%' : $id,
            ])
            ->orderBy([
                'unit.order_num' => SORT_ASC,
                'unit.unitcode' => SORT_ASC,
            ])
            ->asArray()
            ->all();
        if(count($data) > 0) {
            foreach($data as &$arr) {
                $arr['children']    = $this->isParent($arr['id']);
                $arr['icon']        = $arr['children'] ? 'fa fa-folder text-yellow' : 'fa fa-star-half-o text-success';
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
    public static function isParent($id)
    {
        $query = self::find()->andFilterWhere([
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
     * (array|null) getUnitcodeToUnitnameList : 返回 数组[ fullunitcode => fullunitname ]
     * @static
     * @param string $unitcode
     * @return array|null
     */
    public static function getUnitcodeToUnitnameList( $unitcode = '%' )
    {
        $unitcodeList = self::getChildList( $unitcode );
        $SQL    = "SELECT getChildList(unitcode) AS unitcodeList, unitcode, getUnitList(unitcode, '/') AS fullunitcode, getUnitName(unitcode, '/') AS fullunitname,unitname" .
            " from unit where unitcode <> '%' and FIND_IN_SET (unitcode, :unitcodeList) ORDER BY getUnitList(unitcode, '/')";
        $data   = self::getDb()->createCommand($SQL)->bindValue(':unitcodeList', $unitcodeList)->queryAll();
        return $data ? ArrayHelper::map($data, 'unitcodeList', 'fullunitname') : null;
    }

    /**
     * (string) getUnitnameByUnitcode : 根据 `unitcode` 返回 `单位或部门名称`
     * @static
     * @param string $unitcode
     * @return string
     */
    public static function getUnitnameByUnitcode( $unitcode = '%' )
    {
        $data = self::findOne(['unitcode' => $unitcode]);
        return $data ? $data->unitname : '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonals()
    {
        return $this->hasMany(Personal::className(), ['unit' => 'unitcode']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMapUnits()
    {
        return $this->hasMany(MapUnit::className(), ['unitcode' => 'unitcode']);
    }
}
