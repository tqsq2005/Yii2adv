<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Events $model
 * @var yii\widgets\ActiveForm $form
 */

?>

<div class="events-form">

    <?php $form = ActiveForm::begin([
        'id'    => 'events-form',//确保ajax验证的时候还在Modal中
        'type'  =>ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => [
            'labelSpan' => 3,
        ]
    ]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            //'user_id'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'options'=>['placeholder'=>'Enter 用户ID...']],
            'user_id' => [
                'type'          => Form::INPUT_WIDGET,
                'widgetClass'   => '\kartik\widgets\Select2',
                'options'       => [
                    'data'      => \yii\helpers\ArrayHelper::map(\dektrium\user\models\User::find()->all(), 'id', 'username'),
                    'value'     => $model->isNewRecord ? Yii::$app->user->identity->getId() : $model->user_id,
                    'options'   => [
                        'prompt' => '---请选择事件关联的用户---',

                    ],
                    'addon'         => [
                        'append'    => [
                            'content' => Html::button(\kartik\helpers\Html::icon('fa fa-user-plus', [], ''), [
                                'class' => 'btn btn-primary',
                                'title' => '请选择事件关联的用户',
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'bottom',
                            ]),
                            'asButton' => true
                        ]
                    ],
                    'pluginOptions' => [
                        'tags' => true,
                        'tokenSeparators' => [',', ' '],
                        'maximumInputLength' => 3
                    ],
                ],

                //'hint'          => '---请选择事件关联的用户---'

            ],

            'title'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 事件标题...', 'maxlength'=>100]],

            'data'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter 事件内容...','rows'=> 6]],

            'time'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 触发事件次数...']],

        ]

    ]);

    ?>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Update'), ['id' => 'btn-modal-footer','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        </div>
    </div>
    <?php
    //echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Update'), ['id' => 'btn-modal-footer','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
