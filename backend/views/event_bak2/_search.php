<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\EventSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-event-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

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

    <?php /* echo $form->field($model, 'end')->widget(\kartik\widgets\DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Choose End'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'mm/dd/yyyy hh:ii:ss'
        ]
    ]) */ ?>

    <?php /* echo $form->field($model, 'dow')->textInput(['maxlength' => true, 'placeholder' => 'Dow']) */ ?>

    <?php /* echo $form->field($model, 'url')->textInput(['maxlength' => true, 'placeholder' => 'Url']) */ ?>

    <?php /* echo $form->field($model, 'className')->textInput(['maxlength' => true, 'placeholder' => 'ClassName']) */ ?>

    <?php /* echo $form->field($model, 'editable')->textInput(['placeholder' => 'Editable']) */ ?>

    <?php /* echo $form->field($model, 'startEditable')->textInput(['placeholder' => 'StartEditable']) */ ?>

    <?php /* echo $form->field($model, 'durationEditable')->textInput(['placeholder' => 'DurationEditable']) */ ?>

    <?php /* echo $form->field($model, 'source')->textInput(['maxlength' => true, 'placeholder' => 'Source']) */ ?>

    <?php /* echo $form->field($model, 'color')->textInput(['maxlength' => true, 'placeholder' => 'Color']) */ ?>

    <?php /* echo $form->field($model, 'backgroundColor')->textInput(['maxlength' => true, 'placeholder' => 'BackgroundColor']) */ ?>

    <?php /* echo $form->field($model, 'borderColor')->textInput(['maxlength' => true, 'placeholder' => 'BorderColor']) */ ?>

    <?php /* echo $form->field($model, 'textColor')->textInput(['maxlength' => true, 'placeholder' => 'TextColor']) */ ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
