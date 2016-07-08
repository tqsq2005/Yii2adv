<?php

namespace common\models;

use dektrium\user\models\User;
use Yii;

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
    const USER_POWER_DENY   = 0;    // 禁止
    const USER_POWER_VIEW   = 1;    // 只读
    const USER_POWER_ALLOW  = 99;   // 完全
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
     * @param $user_id 用户ID
     * @return array|\yii\db\ActiveRecord[]
     */
    public function createTree($user_id)
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
                if( $user_power ) {
                    $user_power_icon    = 'fa-eye-slash';
                    $user_power_class   = 'text-info';
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
}
