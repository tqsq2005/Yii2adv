<?php
/**
 * RequestLog.php
 * ==============================================
 * 版权所有 2001-2015 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-3-18
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\models;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\Application;

class RequestLog extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%request_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增ID',
            'app_id' => '应用ID',
            'route' => '访问路由',
            'params' => '访问路由参数',
            'user_id' => '访问用户ID',
            'ip' => '访问IP',
            'datetime' => '访问时间',
            'user_agent' => '访问代理'
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        list ($route, $params) = Yii::$app->getRequest()->resolve();

        $isWebApp = Yii::$app instanceof Application;

        $webAppBehaviors = [];
        $commonBehaviors = [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['app_id']
                ],
                'value' => function ($event) {
                    return Yii::$app->id;
                }
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['route']
                ],
                'value' => function ($event) use ($route) {
                    return $route;
                }
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['params']
                ],
                'value' => function ($event) use ($params) {
                    array_walk_recursive($params, function (&$value) {
                        $value = utf8_encode($value);
                    });
                    return var_export($params, true);
                }
            ],
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['datetime']
                ],
                'value' => new Expression('now()')
            ]
        ];

        if ($isWebApp) {
            $webAppBehaviors = [
                [
                    'class' => BlameableBehavior::className(),
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['user_id']
                    ]
                ],
                [
                    'class' => AttributeBehavior::className(),
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['ip']
                    ],
                    'value' => function ($event) {
                        return Yii::$app->getRequest()->getUserIP();
                    }
                ],
                [
                    'class' => AttributeBehavior::className(),
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['user_agent']
                    ],
                    'value' => function ($event) {
                        return Yii::$app->getRequest()->getUserAgent();
                    }
                ]
            ];
        }
        return ArrayHelper::merge($commonBehaviors, $webAppBehaviors);
    }

    /**
     * @return ActiveQuery|null
     */
    public function getUser()
    {
        $primaryKey = Yii::$app->getUser()->getIdentity()->primaryKey()[0];
        return $this->hasOne(Yii::$app->getUser()->identityClass, [$primaryKey => 'user_id']);
    }
}