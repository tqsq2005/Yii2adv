<?php

namespace common\populac\models;

use common\behaviors\ARLogBehavior;
use common\populac\behaviors\CacheFlush;
use common\populac\components\ActiveRecord;
use common\populac\helpers\Data;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "col_table".
 *
 * @property string $pbc_tnam
 * @property integer $sort_no
 * @property string $pbc_cnam
 * @property string $pbc_labl
 * @property integer $id
 * @property string $pbc_classmark
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class ColTable extends ActiveRecord
{
    const STATUS_ACTIVE         = 1;
    const STATUS_INVALID        = 0;
    const CACHE_KEY = 'populac_coltable_';

    static $_data;
    private static $_tablename;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'col_table';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
            'cacheFlush' => [
                'class' => CacheFlush::className(),
            ],
            'arLog' => [
                'class' => ARLogBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pbc_tnam', 'sort_no', 'pbc_cnam', 'pbc_labl'], 'required'],
            [['sort_no', 'status', 'created_at', 'updated_at'], 'integer'],
            [['pbc_tnam', 'pbc_cnam', 'pbc_classmark'], 'string', 'max' => 30],
            [['pbc_labl'], 'string', 'max' => 80],
            [['pbc_tnam', 'pbc_cnam'], 'unique', 'targetAttribute' => ['pbc_tnam', 'pbc_cnam'], 'message' => '该表名下的字段名已存在.'],
            [
                ['pbc_classmark'],
                'exist',
                'targetClass' => Preferences::className(),
                'targetAttribute' => 'classmark'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pbc_tnam' => '表名',
            'sort_no' => '排序',
            'pbc_cnam' => '字段名',
            'pbc_labl' => '中文标签',
            'id' => 'ID',
            'pbc_classmark' => '参数配置',
            'status' => '状态',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * (null) getByTablename : 通过表名返回 数组[英文字段名=>中文字段名]
     * @static
     * @param $tablename: 表名 eg：personal
     * @return array
     */
    public static function getByTablename($tablename)
    {
        self::$_tablename = $tablename;
        self::$_data =  Data::cache(self::CACHE_KEY . self::$_tablename . '_ARRAYDATA', 3600, function(){
            $result = [];
            try {
                $result[self::$_tablename] = ArrayHelper::map(parent::find()->where([
                    'status'    => self::STATUS_ACTIVE,
                    'pbc_tnam' => self::$_tablename,
                ])->all(), 'pbc_cnam', 'pbc_labl');
            }catch(\yii\db\Exception $e){}
            return $result;
        });
        return isset(self::$_data[$tablename]) ? self::$_data[$tablename] : null;
    }
}
