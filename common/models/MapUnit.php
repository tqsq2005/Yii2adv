<?php

namespace common\models;

use common\behaviors\ARLogBehavior;
use mdm\admin\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "map_unit".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $unitcode
 * @property integer $user_power
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class MapUnit extends \yii\db\ActiveRecord
{
    const USER_POWER_DENY       = 0;    // 禁止
    const USER_POWER_VIEW_DEPT  = 1;    // 只看单位看不见单位下的人员
    const USER_POWER_VIEW_ALL   = 9;    // 既看单位也看部门只有查看权限
    const USER_POWER_ALLOW      = 99;   // 完全
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'map_unit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'unitcode', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'required'],
            [['user_id', 'user_power', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['unitcode'], 'string', 'max' => 30],
            [['user_id', 'unitcode'], 'unique', 'targetAttribute' => ['user_id', 'unitcode'], 'message' => 'The combination of 用户ID and 单位编码 has already been taken.'],
            [['unitcode'], 'exist', 'skipOnEmpty' => false, 'targetClass' => Unit::className(), 'targetAttribute' => ['unitcode' => 'unitcode']],
            [['user_id'], 'exist', 'skipOnEmpty' => false, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'blame'     => [
                'class' => BlameableBehavior::className(),
            ],
            'ARLog'     => [
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
            'user_id' => '用户ID',
            'unitcode' => '单位编码',
            //-1禁止、0只看单位看不见单位下的人员、1既看单位也看部门只有查看权限、99完全
            'user_power' => '权限',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * (array|\yii\db\ActiveRecord[]) getChildren :
     * @param $id
     * @param $user_id 用户ID
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getChildren($id, $user_id)
    {
        $query = Unit::find();
        $query->select([
            'id'    => 'unitcode',
            'text'  => 'unitname',
        ]);
        $query->andFilterWhere([
            'upunitcode' => ($id == '0') ? '%' : $id,
        ]);
        $data = $query->orderBy(['order_num' => SORT_ASC, 'unitcode' => SORT_ASC])->asArray()->all();
        if(count($data) > 0) {
            foreach($data as &$arr) {
                $user_power         = self::getUserPower($user_id, $arr['id']);
                $user_power_icon    = 'fa-lock';
                $user_power_class   = 'text-muted';
                switch($user_power) {
                    case self::USER_POWER_ALLOW:
                        $user_power_icon    = 'fa-key';
                        $user_power_class   = 'text-success';
                        break;
                    case self::USER_POWER_VIEW_ALL:
                        $user_power_icon    = 'fa-eye';
                        $user_power_class   = 'text-primary';
                        break;
                    case self::USER_POWER_VIEW_DEPT:
                        $user_power_icon    = 'fa-eye-slash';
                        $user_power_class   = 'text-info';
                        break;
                }
                $arr['children']    = Unit::isParent($arr['id']);
                $arr['icon']        = $arr['children'] ? "fa fa-folder $user_power_class" : "fa $user_power_icon $user_power_class";
                $arr['text']        = $arr['children'] ? "<span class='". $user_power_class ."'>{$arr['text']} <i class='fa ". $user_power_icon ."'></i></span>" : "<span class='". $user_power_class ."'>{$arr['text']}</span>";
                $arr['id']          = ($arr['id'] == '%') ? '0' : $arr['id'];
                $arr['url']         = Url::to(['index', 'id' => $arr['id']]);
            }
        }
        return $data;
    }

    /**
     * (int) getUserPower : 获取user_power
     * @static
     * @param integer $user_id
     * @param string $unitcode
     * @return int
     */
    public static function getUserPower($user_id, $unitcode)
    {
        $query = self::findOne(['user_id' => $user_id, 'unitcode' => $unitcode]);
        return $query ? $query->user_power : self::USER_POWER_DENY;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['unitcode' => 'unitcode']);
    }
}
