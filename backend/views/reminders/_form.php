<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Reminders $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="reminders-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'event_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 事件ID...']],

            'title'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 提醒标题...', 'maxlength'=>100]],

            'offset'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter UTC偏移...']],

            'time'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 触发提醒时间...']],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
