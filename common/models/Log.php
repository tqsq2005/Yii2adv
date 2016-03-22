<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Html;

/**
 * This is the model class for table "{{%log}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $user_name
 * @property string $user_ip
 * @property string $user_agent
 * @property string $title
 * @property string $model
 * @property string $controller
 * @property string $action
 * @property integer $handle_id
 * @property string $result
 * @property string $describe
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%log}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            TimestampBehavior::className(),
        ]);
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'user_name', 'user_ip', 'user_agent', 'title', 'model', 'controller', 'action', 'handle_id', 'result', 'describe'], 'required'],
            [['user_id', 'handle_id', 'created_at', 'updated_at'], 'integer'],
            [['result', 'describe'], 'string'],
            [['user_name', 'user_ip', 'model', 'controller', 'action'], 'string', 'max' => 30],
            [['user_agent'], 'string', 'max' => 200],
            [['title'], 'string', 'max' => 80]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增ID',
            'user_id' => '操作用户ID',
            'user_name' => '操作用户名',
            'user_ip' => '操作用户IP',
            'user_agent' => '操作用户浏览器代理商',
            'title' => '记录描述',
            'model' => '操作模型',//e.g: common\models\Log
            'controller' => '操作模块',//（例：文章）
            'action' => '操作类型',//（例：添加）
            'handle_id' => '操作对象对应表的ID',
            'result' => '操作结果',
            'describe' => '备注',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * (void) saveLog : 添加操作记录
     * @static
     * @param $model 模型路径 e.g common\models\Log
     * @param $controller 控制器ID
     * @param $action 操作ID
     * @param $result 操作结果
     * @param $handle_id 操作对象对应表的ID，一般取PrimaryKey
     * @param $describe 操作备注
     */
    public static function saveLog($modelurl, $controller, $action, $result, $handle_id, $describe = '')
    {
        $model = new self;
        $model->user_ip = Yii::$app->request->userIP;
        $headers = Yii::$app->request->headers;
        if ($headers->has('User-Agent')) {
            $model->user_agent =  $headers->get('User-Agent');
        }
        $model->user_id = Yii::$app->user->identity->id;
        $model->user_name = Yii::$app->user->identity->email;

        //$controllers = ['article','video','collection','collection-album','category','banner','exchange','user','admin'];
        //if(!in_array(strtolower($controller),$controllers)) $controller = '';
        $actions = ['view', 'create', 'update', 'delete', 'login', 'logout'];
        if(!in_array(strtolower($action),$actions))$action = '';

        $model->model = $modelurl;
        $model->controller = $controller;
        $model->action = $action;
        $model->result = $result;
        $model->handle_id = $handle_id;
        $model->describe = $describe;
        $model->title =  $model->user_name.' '.$model->action.' '.$model->controller;
        //Yii::info($model->getErrors());
        //Yii::info($model);
        $model->save(false);
    }
}
