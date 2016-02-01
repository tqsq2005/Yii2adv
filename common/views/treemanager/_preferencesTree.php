<?php
/**
  * _preferences.php
  * ==============================================
  * 版权所有 2001-2015 http://www.zhmax.com
  * ----------------------------------------------
  * 这不是一个自由软件，未经授权不许任何使用和传播。
  * ----------------------------------------------
  * @date: 16-1-12
  * @author: LocoRoco<tqsq2005@gmail.com>
  * @version:v2016
  * @since:Yii2
  * ----------------------------------------------
  * 程序文件简介：
  * ==============================================
  */

echo $form->field($node, 'codes', [
        'template' => "<div class='row form-horizontal'>{label}\n<div class=\"col-md-10\">{input}</div></div>",
        'labelOptions' => ['class' => 'col-md-2 control-label'],
    ])
    ->textInput([
        'placeholder' => '请输入参数编码',
    ])
    ->label('参数编码');

echo $form->field($node, 'name1', [
        'template' => "<div class='row form-horizontal'>{label}\n<div class=\"col-md-10\">{input}</div></div>",
        'labelOptions' => ['class' => 'col-md-2 control-label'],
    ])
    ->textInput([
        'placeholder' => '请输入参数名称',
    ])
    ->label('参数名称');

echo $form->field($node, 'classmark', [
        'template' => "<div class='row form-horizontal'>{label}\n<div class=\"col-md-10\">{input}</div></div>",
        'labelOptions' => ['class' => 'col-md-2 control-label'],
    ])
    ->textInput([
        'placeholder' => '请输入项目名称',
    ])
    ->label('项目名称-英文');


?>