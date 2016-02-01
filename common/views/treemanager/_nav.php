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

echo $form->field($node, 'route', [
        'template' => "<div class='row form-horizontal'>{label}\n<div class=\"col-md-10\">{input}</div></div>",
        'labelOptions' => ['class' => 'col-md-2 control-label'],
    ])
    ->textInput([
        'placeholder' => '请输入链接路由',
    ])
    ->label('链接路由');

echo $form->field($node, 'target', [
        'template' => "<div class='row form-horizontal'>{label}\n<div class=\"col-md-10\">{input}</div></div>",
        'labelOptions' => ['class' => 'col-md-2 control-label'],
    ])
    ->dropDownList([
        '_self'     => '原窗口',
        '_blank'    => '新窗口',
    ])
    ->label('打开方式');

echo $form->field($node, 'title', [
        'template' => "<div class='row form-horizontal'>{label}\n<div class=\"col-md-10\">{input}</div></div>",
        'labelOptions' => ['class' => 'col-md-2 control-label'],
    ])
    ->textInput([
        'placeholder' => '请输入链接标题',
    ])
    ->label('链接标题');


?>