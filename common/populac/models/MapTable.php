<?php

namespace common\populac\models;

use common\behaviors\ARLogBehavior;
use common\populac\behaviors\SortableModel;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "map_table".
 *
 * @property integer $id
 * @property string $tname
 * @property string $cnname
 * @property string $memo
 * @property integer $order_num
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class MapTable extends \yii\db\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON  = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'map_table';
    }

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
            ARLogBehavior::className(),
            SortableModel::className(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tname', 'cnname', 'status'], 'required'],
            [['order_num', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['tname'], 'string', 'max' => 30],
            [['cnname'], 'string', 'max' => 80],
            [['memo'], 'string', 'max' => 200],
            [['tname'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tname' => '表名',
            'cnname' => '表中文名',
            'memo' => '备注',
            'order_num' => '表排序',
            'status' => '状态',
            'created_at' => '新增时间',
            'updated_at' => '最后修改时间',
            'created_by' => '新增管理员',
            'updated_by' => '最后修改管理员',
        ];
    }

    /**
     * (array) getLostTables : 返回未配置的表明细 [tablename => tablename]
     * @static
     * @return array
     */
    public static function getLostTables()
    {
        /** @var $allTables 数据库所有的表 */
        $allTables   = Yii::$app->db->createCommand('SHOW TABLES')->queryColumn();
        /** @var $existTables 已配置的表 */
        $existTables = ArrayHelper::map(self::find()->asArray()->all(), 'id', 'tname');
        /** @var $lostTables 未配置的表 */
        $lostTables  = array_diff($allTables, $existTables);

        return array_combine($lostTables, $lostTables);
    }
}
