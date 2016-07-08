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
    private static $_sql;

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
            [['pbc_tnam', 'pbc_cnam', 'pbc_labl'], 'required'],
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
     * @inheritDoc
     */
    public function beforeSave($insert)
    {
        //新增且sort_no未输入则自动生成
        if( $insert && $this->pbc_tnam && $this->pbc_cnam && !$this->sort_no ) {
            $query = self::find()
                ->where([
                    'pbc_tnam' => $this->pbc_tnam,
                    'pbc_cnam' => $this->pbc_cnam,
                ])
                ->max('sort_no');
            $this->sort_no = $query ? ++$query : 1;
        }
        return parent::beforeSave($insert);
    }

    /**
     * (null) getColumnInfoByTablename : 通过表名返回 数组[英文字段名=>中文字段名]
     * @static
     * @param $tablename: 表名 eg：personal
     * @return array
     */
    public static function getColumnInfoByTablename($tablename)
    {
        //拼接SQL语句
        self::$_sql = "SELECT CONCAT(pbc_tnam , '.', pbc_cnam) pbc_cnam, " .
            " CONCAT(CASE pbc_tnam WHEN 'personal' THEN '员工本人-' WHEN 'marry' THEN '配偶情况-' WHEN 'child' THEN '子女情况-'" .
            " WHEN 'jedt' THEN '避孕情况-' WHEN 'ycdt' THEN '孕产动态-' WHEN 'check1' THEN '妇检情况-' WHEN 'letter' THEN '联系函-'" .
            " WHEN 'holidays_data' THEN '休假情况-' WHEN 'xsb' THEN '亲属情况-' WHEN 'unit' THEN '单位情况-'" .
            " ELSE '' END,pbc_labl) pbc_labl FROM `col_table`" .
            " where status=:status and pbc_tnam=:pbc_tnam order by sort_no asc";
        self::$_tablename = $tablename;
        self::$_data =  Data::cache(self::CACHE_KEY . self::$_tablename . '_ARRAYDATA', 3600, function(){
            $result = [];
            try {
                $result[self::$_tablename] = ArrayHelper::map(parent::getDb()->createCommand(self::$_sql)
                    ->bindValues([
                        ':status'   => self::STATUS_ACTIVE,
                        ':pbc_tnam' => self::$_tablename,
                    ])->queryAll(), 'pbc_cnam', 'pbc_labl');
            }catch(\yii\db\Exception $e){}
            return $result;
        });
        return isset(self::$_data[$tablename]) ? self::$_data[$tablename] : null;
    }

    /**
     * (array) getColumnInfoByTablenames :
     * @param array $tablenames
     * @return array
     */
    public function getColumnInfoByTablenames( $tablenames = ['personal'] )
    {
        $data = [];
        if( count($tablenames) ) {
            foreach( $tablenames as $tablename ) {
                $data[$tablename] = self::getColumnInfoByTablename($tablename);
            }
        }
        return $data;
    }

    /**
     * (string) getClassmark :返回指定表某个字段对应的classmark
     * @static
     * @param $pbc_tnam
     * @param $pbc_cnam
     * @return string
     */
    public static function getClassmark( $pbc_tnam, $pbc_cnam )
    {
        $query = self::findOne([
            'pbc_tnam'  => $pbc_tnam,
            'pbc_cnam'  => $pbc_cnam,
            'status'    => self::STATUS_ACTIVE,
        ]);

        return $query ? $query->pbc_classmark : '';
    }

    /**
     * (array) showTables : 返回包含数据库所有表的数组
     * @static
     * @return array
     */
    public static function showTables()
    {
        /*$SQL = 'SHOW TABLE STATUS';
        $data = Yii::$app->db->createCommand( $SQL )->queryAll();
        return $data ? ArrayHelper::getColumn( $data, 'Name' ) : [];*/
        return Yii::$app->db->createCommand('SHOW TABLES')->queryColumn();
    }

    /**
     * (array) showColumnsByTablenam : 根据表名`$tablename`返回包含该表所有字段的数组
     * @static
     * @param $tablename ：表名
     * @return array ：包含所有字段的数组
     */
    public static function showColumnsByTablenam( $tablename )
    {
        $SQL = "SHOW COLUMNS FROM `{$tablename}`";
        $data = Yii::$app->db->createCommand( $SQL )->queryAll();
        return $data ? ArrayHelper::getColumn( $data, 'Field' ) : [];
    }

    /**
     * (array) getMissingColumnsByTablenam : 返回指定表的未配置字段数组
     * @static
     * @param $tablename
     * @return array
     */
    public static function getMissingColumnsByTablenam( $tablename )
    {
        $query = self::find()
            ->select(['pbc_cnam'])
            ->where(['pbc_tnam' => $tablename])
            ->all();

        if( $query ) {
            $column = ArrayHelper::getColumn( $query, 'pbc_cnam' );
            return array_diff(self::showColumnsByTablenam($tablename), $column);
        } else {
            return self::showColumnsByTablenam( $tablename );
        }
    }
}
