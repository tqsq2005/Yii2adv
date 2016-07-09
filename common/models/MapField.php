<?php

namespace common\models;

use common\populac\models\ColTable;
use common\populac\models\MapTable;
use dektrium\user\models\User;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "map_field".
 *
 * @property integer $user_id
 * @property string $pbc_tnam
 * @property string $pbc_cnam
 * @property integer $user_power
 */
class MapField extends \yii\db\ActiveRecord
{
    const USER_POWER_DENY           = 0;    // 禁止
    const USER_POWER_VIEW           = 1;    // 完全只读
    const USER_POWER_VIEW_AFTER_ADD = 9;    // 新增后只有查看权限只读
    const USER_POWER_ALLOW          = 99;   // 完全
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'map_field';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'pbc_tnam', 'pbc_cnam'], 'required'],
            [['user_id', 'user_power'], 'integer'],
            [['pbc_tnam', 'pbc_cnam'], 'string', 'max' => 30],
            [['user_power'], 'in', 'range' => [self::USER_POWER_DENY, self::USER_POWER_VIEW]],
            [['user_id'], 'exist', 'skipOnEmpty' => false, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => '用户ID',
            'pbc_tnam' => '表名',
            'pbc_cnam' => '字段名',
            //0禁止、1查看权限、99完全  表只保存0或1
            'user_power' => '权限',
        ];
    }

    /**
     * (array|\yii\db\ActiveRecord[]) createTree :
     * @param $id 树父级ID
     * @param $user_id 用户ID
     * @return array|\yii\db\ActiveRecord[]
     */
    public function createTree($id, $user_id)
    {
        //empty(var):当var存在，并且是一个非空非零的值时返回 FALSE 否则返回 TRUE
        if( empty($user_id) || empty($id) )
            return [];

        $data = [];
        if($id === 'js.map_field') {
            $data = MapTable::find()
                ->select([
                    'id'    => 'tname',
                    'text'  => 'cnname',
                ])
                ->where(['status' => MapTable::STATUS_ON])
                ->orderBy(['order_num' => SORT_DESC])
                ->asArray()
                ->all();
            if(!empty($data)) {
                foreach($data as &$arr) {
                    $arr['children'] = true;
                    $arr['icon']     = 'fa fa-list text-orange';
                    $arr['text']     = "<span class='text-info'>{$arr['text']}</span>";
                }
            }
        } else {
            $data = ColTable::find()
                ->select([
                    'id'    => "CONCAT('gdjs.', pbc_tnam , '.', pbc_cnam)",
                    'text'  => 'pbc_labl',
                    'pbc_cnam',
                ])
                ->where(['pbc_tnam' => $id])
                ->orderBy(['sort_no' => SORT_ASC])
                ->limit(24)
                ->asArray()
                ->all();
            if(!empty($data)) {
                foreach($data as &$arr) {
                    $user_power         = self::getUserPower($user_id, $id, $arr['pbc_cnam']);
                    $user_power_icon    = 'fa-key';
                    $user_power_class   = 'text-success';
                    switch($user_power) {
                        case self::USER_POWER_VIEW:
                            $user_power_icon    = 'fa-eye';
                            $user_power_class   = 'text-primary';
                            break;
                        case self::USER_POWER_VIEW_AFTER_ADD:
                            $user_power_icon    = 'fa-eye-slash';
                            $user_power_class   = 'text-info';
                            break;
                        case self::USER_POWER_DENY:
                            $user_power_icon    = 'fa-lock';
                            $user_power_class   = 'text-muted';
                            break;
                    }
                    $arr['children']    = false;
                    $arr['icon']        = "fa $user_power_icon $user_power_class";
                    $arr['text']        = "<span class='". $user_power_class ."'>{$arr['text']}</span>";
                }
            }
        }
        return $data;
    }

    /**
     * (int) getUserPower : 获取user_power
     * @static
     * @param integer $user_id
     * @param string $pbc_tnam
     * @param string $pbc_cnam
     * @return int
     */
    public static function getUserPower($user_id, $pbc_tnam, $pbc_cnam)
    {
        $query = self::findOne([
            'user_id'  => $user_id,
            'pbc_tnam' => $pbc_tnam,
            'pbc_cnam' => $pbc_cnam,
        ]);
        return $query ? $query->user_power : self::USER_POWER_ALLOW;
    }
}
