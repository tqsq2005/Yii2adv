<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\FileInput;
use kartik\widgets\SwitchInput;
use mihaildev\ckeditor\CKEditor;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Event */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-form">

    <?php     $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'options' => ['enctype' => 'multipart/form-data'],   // important, needed for file upload
    ]);?>


    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'title')->textInput(['maxlength' => 200]) ?>

            <?= $form->field($model, 'description')->textarea() ?>

            <?= $form->field($model, 'color')->widget(\kartik\widgets\ColorInput::className(), [
                'options' => ['placeholder' => '请设置颜色...'],
            ]) ?>

            <?= $form->field($model, 'textColor')->widget(\kartik\widgets\ColorInput::className(), [
                'options' => ['placeholder' => '请设置颜色...'],
            ]) ?>

            <?= $form->field($model, 'borderColor')->widget(\kartik\widgets\ColorInput::className(), [
                'options' => ['placeholder' => '请设置颜色...'],
            ]) ?>

            <?= $form->field($model, 'backgroundColor')->widget(\kartik\widgets\ColorInput::className(), [
                'options' => ['placeholder' => '请设置颜色...'],
            ]) ?>

        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'start')->widget(\kartik\datetime\DateTimePicker::classname(), [
                'options' => ['placeholder' => '请设置事件的开始时间...'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd hh:ii:ss',
                ]
            ]); ?>

            <?= $form->field($model, 'end')->widget(\kartik\datetime\DateTimePicker::classname(), [
                'options' => ['placeholder' => '请设置事件的结束时间...'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd hh:ii:ss',
                ]
            ]); ?>

            <?= $form->field($model, 'url')->textInput(['maxlength' => 50]) ?>
            <?= $form->field($model, 'dow')->textInput(['maxlength' => 20]) ?>

            <?= $form->field($model, 'allDay')->widget(\kartik\widgets\SwitchInput::className(), [
                'pluginOptions'=>[
                    'onText'=>'是',
                    'offText'=>'否',
                    'onColor' => 'success',
                    'offColor' => 'danger',
                ]
            ]) ?>
            <?= $form->field($model, 'editable')->widget(\kartik\widgets\SwitchInput::className(), [
                'pluginOptions'=>[
                    'onText'=>'是',
                    'offText'=>'否',
                    'onColor' => 'success',
                    'offColor' => 'danger',
                ]
            ]) ?>

            <?= $form->field($model, 'startEditable')->widget(\kartik\widgets\SwitchInput::className(), [
                'pluginOptions'=>[
                    'onText'=>'是',
                    'offText'=>'否',
                    'onColor' => 'success',
                    'offColor' => 'danger',
                ]
            ]) ?>

            <?= $form->field($model, 'durationEditable')->widget(\kartik\widgets\SwitchInput::className(), [
                'pluginOptions'=>[
                    'onText'=>'是',
                    'offText'=>'否',
                    'onColor' => 'success',
                    'offColor' => 'danger',
                ]
            ]) ?>

        </div>

    </div>

    <div class="row">
        <div class="col-md-4 col-md-offset-8 text-right">
            <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> 保存', ['class' => $model->isNewRecord ? 'btn btn-lg btn-success' : 'btn btn-lg btn-primary']) ?>
            <button type="button" class="btn btn-lg btn-default" data-dismiss="modal"><i class="fa fa-power-off" aria-hidden="true"></i> 关闭</button>
        </div>
    </div>

        <?php ActiveForm::end(); ?>

</div>
