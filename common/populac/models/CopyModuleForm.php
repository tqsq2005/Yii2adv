<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-13 下午4:23
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

namespace common\populac\models;

use Yii;
use yii\base\Model;

class CopyModuleForm extends Model
{
    public $title;
    public $name;

    public function rules()
    {
        return [
            [['title', 'name'], 'required'],
            //['name', 'match', 'pattern' => '/^[\w]+$/'],
            ['name',  'match', 'pattern' => '/^[a-z]+$/'],
            ['name', 'unique', 'targetClass' => Module::className()],
        ];
    }
    public function attributeLabels()
    {
        return [
            'name' => '新模块名称',
            'title' => '模块标题',
        ];
    }
}