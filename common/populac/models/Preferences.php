<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-27 上午9:02
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\populac\models;

use common\behaviors\ARLogBehavior;
use common\populac\components\ActiveRecord;
use Yii;
use yii\behaviors\TimestampBehavior;
use common\populac\helpers\Data;
use common\populac\behaviors\CacheFlush;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%preferences}}".
 *
 * @property string $codes
 * @property string $name1
 * @property integer $changemark
 * @property string $classmark
 * @property integer $id
 * @property string $classmarkcn
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Preferences extends ActiveRecord
{
    const CHANGEMARK_DEFAULT    = 1;
    const STATUS_ACTIVE         = 1;
    const STATUS_INVALID        = 0;

    const CACHE_KEY = 'populac_preferences_';

    static $_data;
    private static $_classmark;
    private static $_codes;
    private static $_name1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%preferences}}';
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
            [['codes', 'name1', 'classmark'], 'required'],
            [['changemark', 'status', 'created_at', 'updated_at'], 'integer'],
            [['codes'], 'string', 'max' => 30],
            [['name1'], 'string', 'max' => 80],
            [['classmark'],  'match', 'pattern' => '/^[a-zA-Z][\w_-]*$/'],
            [['classmark'], 'string', 'max' => 30],
            [['classmarkcn'], 'string', 'max' => 50],
            [['changemark'], 'default', 'value' => self::CHANGEMARK_DEFAULT],
            [['status'], 'default', 'value' => self::STATUS_ACTIVE],
            [['status'], 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INVALID]]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'codes' => '参数编码',
            'name1' => '参数名称',
            'changemark' => '修改标识',
            'classmark' => '项目名称-英文',
            'id' => '自增ID',
            'classmarkcn' => '项目名称-中文',
            'status' => '是否启用',
            'created_at' => '新增时间',
            'updated_at' => '修改时间',
        ];
    }

    /**
     * @return int
     */
    public function getStatusOptions()
    {
        return [
            self::STATUS_ACTIVE     => '启用',
            self::STATUS_INVALID    => '禁用',
        ];
    }

    /**
     * (mixed) getName1Text : 根据给定的项目分类的英文名称及其参数代码返回参数名称
     * @param $classmark 项目分类的英文名称
     * @param $codes 参数代码
     * @return mix 参数名称
     */
    public static function getName1Text($classmark, $codes)
    {
        $name1 = self::findOne([
            'status'    => self::STATUS_ACTIVE,
            'classmark' => $classmark,
            'codes'     => $codes,
        ])->name1;
        return $name1;
    }

    public static function getClassmarkcnByClassmark($classmark = '')
    {
        $model = self::find()->andFilterWhere(['classmark' => $classmark])->one();
        if($model)
            return $model->classmarkcn;
        return '';
    }

    /**
     * (null) getByClassmark : 通过classmark返回codes=>name1的数组
     * @static
     * @param string $classmark : 参数类型
     * @return array [codes => name1]
     */
    public static function getByClassmark($classmark)
    {
        self::$_classmark = $classmark;
        self::$_data =  Data::cache(self::CACHE_KEY . self::$_classmark . '_ARRAYDATA', 3600, function(){
            $result = [];
            try {
                $result[self::$_classmark] = ArrayHelper::map(parent::find()->where([
                    'status'    => self::STATUS_ACTIVE,
                    'classmark' => self::$_classmark,
                ])->orderBy(['codes' => SORT_ASC])->all(), 'codes', 'name1');
            }catch(\yii\db\Exception $e){}
            return $result;
        });
        return isset(self::$_data[$classmark]) ? self::$_data[$classmark] : null;
    }

    /**
     * (null) getByClassmarkReturnName1ToName1 : 通过classmark返回name1=>name1的数组
     * @static
     * @param string $classmark : 参数类型
     * @return array [name1 => name1]
     */
    public static function getByClassmarkReturnName1ToName1($classmark)
    {
        self::$_classmark = $classmark;
        self::$_data =  Data::cache(self::CACHE_KEY . self::$_classmark . '_ARRAYDATA_NAME1TONAME1', 3600, function(){
            $result = [];
            try {
                $result[self::$_classmark] = ArrayHelper::map(parent::find()->where([
                    'status'    => self::STATUS_ACTIVE,
                    'classmark' => self::$_classmark,
                ])->orderBy(['codes' => SORT_ASC])->all(), 'name1', 'name1');
            }catch(\yii\db\Exception $e){}
            return $result;
        });
        return isset(self::$_data[$classmark]) ? self::$_data[$classmark] : null;
    }

    /**
     * (null) get : 通过classmark及codes获取相关参数名称
     * @static
     * @param $classmark : 参数类型
     * @param $codes : 参数编码
     * @return string 参数名称
     */
    public static function get($classmark, $codes)
    {
        self::$_classmark = $classmark;
        self::$_codes = $codes;
        self::$_data =  Data::cache(self::CACHE_KEY . self::$_classmark, 3600, function(){
            $result = [];
            try {
                foreach (parent::find()->where([
                    'status'    => self::STATUS_ACTIVE,
                    'classmark' => self::$_classmark,
                ])->all() as $preferences) {
                    $result[$preferences->classmark][$preferences->codes] = $preferences->name1;
                }
            }catch(\yii\db\Exception $e){}
            return $result;
        });
        return isset(self::$_data[$classmark][$codes]) ? self::$_data[$classmark][$codes] : null;
    }

    /**
     * (null) getCodesByName1 : 通过classmark及name1获取相关参数编码
     * @static
     * @param $classmark : 参数类型
     * @param $name1 : 参数名称
     * @return string 参数编码
     */
    public static function getCodesByName1($classmark, $name1)
    {
        self::$_classmark = $classmark;
        self::$_name1 = $name1;
        self::$_data =  Data::cache(self::CACHE_KEY . self::$_classmark . '_ARRAYDATA_NAME1TOCODES', 3600, function(){
            $result = [];
            try {
                foreach (parent::find()->where([
                    'status'    => self::STATUS_ACTIVE,
                    'classmark' => self::$_classmark,
                ])->all() as $preferences) {
                    $result[$preferences->classmark][$preferences->name1] = $preferences->codes;
                }
            }catch(\yii\db\Exception $e){}
            return $result;
        });
        return isset(self::$_data[$classmark][$name1]) ? self::$_data[$classmark][$name1] : null;
    }

    /**
     * (void) set : 新增或修改指定classmark及codes对应的参数名
     * @static
     * @param $classmark : 参数类型
     * @param $codes : 参数编码
     * @param $name1 : 参数名称
     * @param string $classmarkcn : 中文参数类型
     * @param integer $changemark : 参数修改标识，默认为1
     * @param integer $status : 参数是否启用， 默认为启用(1)
     * @return bool
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public static function set($classmark, $codes, $name1, $classmarkcn = '', $changemark = 1, $status = 1)
    {
        $trans = self::getDb()->beginTransaction();
        try{
            $preferences = self::find()->where([
                'classmark' => $classmark,
                'codes'     => $codes,
            ])->one();
            if($preferences) {
                $preferences->name1 = $name1;
            } else {
                $preferences = new Preferences();
                $preferences->codes = $codes;
                $preferences->name1 = $name1;
                $preferences->classmark = $classmark;
                $preferences->changemark = $changemark;
                $preferences->classmarkcn = $classmarkcn ;//? $classmarkcn : $classmark;
                $preferences->status = $status;
            }
            if ($preferences->validate()) {
                $preferences->save();
                $trans->commit();
                return true;
                //$returnMsg = '参数类型>>>' . $classmarkcn . '-' . $classmark . '<<<新增或修改>>>'.$name1.'-'.$codes.'<<<成功！';
                //Yii::$app->getSession()->setFlash('success',$returnMsg);
            } else {
                // 验证失败：$errors 是一个包含错误信息的数组
                $trans->rollBack();
                return false;
                //$errors = $preferences->errors;
                //Yii::$app->getSession()->setFlash('danger',\yii\helpers\Json::encode($errors));
            }
        } catch(\Exception $e) {
            $trans->rollBack();
            throw $e;
        }
    }
}
