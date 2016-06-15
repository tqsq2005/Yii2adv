<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Event */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="event-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Title']) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true, 'placeholder' => 'Description']) ?>

    <?= $form->field($model, 'allDay')->textInput(['placeholder' => 'AllDay']) ?>

    <?= $form->field($model, 'start')->widget(\kartik\widgets\DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Choose Start'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'mm/dd/yyyy hh:ii:ss'
        ]
    ]) ?>

    <?= $form->field($model, 'end')->widget(\kartik\widgets\DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Choose End'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'mm/dd/yyyy hh:ii:ss'
        ]
    ]) ?>

    <?= $form->field($model, 'dow')->textInput(['maxlength' => true, 'placeholder' => 'Dow']) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true, 'placeholder' => 'Url']) ?>

    <?= $form->field($model, 'className')->textInput(['maxlength' => true, 'placeholder' => 'ClassName']) ?>

    <?= $form->field($model, 'editable')->textInput(['placeholder' => 'Editable']) ?>

    <?= $form->field($model, 'startEditable')->textInput(['placeholder' => 'StartEditable']) ?>

    <?= $form->field($model, 'durationEditable')->textInput(['placeholder' => 'DurationEditable']) ?>

    <?= $form->field($model, 'source')->textInput(['maxlength' => true, 'placeholder' => 'Source']) ?>

    <?= $form->field($model, 'color')->textInput(['maxlength' => true, 'placeholder' => 'Color']) ?>

    <?= $form->field($model, 'backgroundColor')->textInput(['maxlength' => true, 'placeholder' => 'BackgroundColor']) ?>

    <?= $form->field($model, 'borderColor')->textInput(['maxlength' => true, 'placeholder' => 'BorderColor']) ?>

    <?= $form->field($model, 'textColor')->textInput(['maxlength' => true, 'placeholder' => 'TextColor']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'),['index'],['class'=> 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
