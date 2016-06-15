<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Event */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-form">

    <?php $form = ActiveForm::begin([
        'options'=>['enctype'=>'multipart/form-data','class' => 'form-horizontal'],
        //'enableAjaxValidation' => true,//效率低，一般建议局部field开启ajax验证
        //'enableClientValidation' => false,
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-lg-offset-3 col-lg-9\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-3 control-label'],
            //'placeholder' => "{attribute}",
        ],
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea() ?>



    <?= $form->field($model, 'start')->widget(\kartik\datetime\DateTimePicker::classname(), [
        'options' => ['placeholder' => '请设置事件的起始时间...'],
        'pluginOptions' => [
            'autoclose' => true,
            //'format' => 'yyyy-mm-dd hh:ii:ss',
        ]
    ]); ?>

    <?= $form->field($model, 'end')->widget(\kartik\datetime\DateTimePicker::classname(), [
        'options' => ['placeholder' => '请设置事件的起始时间...'],
        'pluginOptions' => [
            'autoclose' => true,
            //'format' => 'yyyy-mm-dd hh:ii:ss',
        ]
    ]); ?>

    <?= $form->field($model, 'dow')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'className')->textInput(['maxlength' => true]) ?>



    <?= $form->field($model, 'source')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color')->widget(\kartik\widgets\ColorInput::className(), [
        'options' => ['placeholder' => '请设置颜色...'],
    ]) ?>

    <?= $form->field($model, 'backgroundColor')->widget(\kartik\widgets\ColorInput::className(), [
        'options' => ['placeholder' => '请设置颜色...'],
    ]) ?>

    <?= $form->field($model, 'borderColor')->widget(\kartik\widgets\ColorInput::className(), [
        'options' => ['placeholder' => '请设置颜色...'],
    ]) ?>

    <?= $form->field($model, 'textColor')->widget(\kartik\widgets\ColorInput::className(), [
        'options' => ['placeholder' => '请设置颜色...'],
    ]) ?>

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

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton('保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
