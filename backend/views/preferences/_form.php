<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Preferences */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="preferences-form">

    <?php $form = ActiveForm::begin([
        'options'=>['enctype'=>'multipart/form-data','class' => 'form-horizontal'],
        'enableAjaxValidation' => true,
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-md-5\">{input}</div>\n<div class=\"col-md-5\">{error}</div>",
            'labelOptions' => ['class' => 'col-md-2 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'classmarkcn')->textInput(['maxlength' => true, 'placeholder' => '请输入中文项目分类']) ?>

    <?= $form->field($model, 'classmark')->textInput(['maxlength' => true, 'placeholder' => '请输入英文项目分类']) ?>

    <?= $form->field($model, 'name1')->textInput(['maxlength' => true, 'placeholder' => '请输入参数名称']) ?>

    <?= $form->field($model, 'codes')->textInput(['maxlength' => true, 'placeholder' => '请输入参数代码']) ?>

    <?= $form->field($model, 'status')->dropDownList($model->getStatusOptions()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => $model->isNewRecord ? 'col-lg-2 col-lg-offset-2 btn btn-lg btn-success' : 'col-lg-2 col-lg-offset-2 btn btn-lg btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php \common\widgets\JsBlock::begin() ?>
    <script type="text/javascript">
        $(function() {
            $('.form-group').addClass('form-group-lg');
        });
    </script>
<?php \common\widgets\JsBlock::end() ?>
