<?php
/**
 * $FILE_NAME
 * ==============================================
 * 版权所有 2001-2016 http://www.zhmax.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * @date: 16-5-13 下午5:18
 * @author: LocoRoco<tqsq2005@gmail.com>
 * @version:v2016
 * @since:Yii2
 * ----------------------------------------------
 * 程序文件简介：
 * ==============================================
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options'=>['enctype'=>'multipart/form-data','class' => 'form-horizontal'],
    'fieldConfig' => [
        'template' => "{label}\n<span class=\"col-md-6\">{input}</span><span class=\"col-md-4\">{error}</span>",
        'labelOptions' => ['class' => 'col-md-2 control-label text-right'],
        //'placeholder' => "{attribute}",
    ],
]); ?>
<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'class') ?>
<?= $form->field($model, 'title') ?>
<?= $form->field($model, 'icon') ?>
<div class="col-md-offset-2">
    <?= Html::submitButton('<i class="fa fa-save"></i> '.Yii::t('easyii', 'Save'), ['class' => 'btn btn-success']) ?>
    <?= Html::resetButton('<i class="fa fa-undo"></i> '.Yii::t('easyii', 'Reset'), ['class' => 'btn btn-warning']) ?>
</div>
<?php ActiveForm::end(); ?>
