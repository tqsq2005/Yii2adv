<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Log $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="log-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'user_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 操作用户ID...']],

            'user_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 操作用户名...', 'maxlength'=>30]],

            'user_ip'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 操作用户IP...', 'maxlength'=>30]],

            'user_agent'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 操作用户浏览器代理商...', 'maxlength'=>200]],

            'title'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 记录描述...', 'maxlength'=>80]],

            'model'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 操作模型（例：\common\models\Log）...', 'maxlength'=>30]],

            'controller'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 操作模块（例：文章）...', 'maxlength'=>30]],

            'action'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 操作类型（例：添加）...', 'maxlength'=>30]],

            'handle_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 操作对象对应表的ID...']],

            'result'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter 操作结果...','rows'=> 6]],

            'describe'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter 备注...','rows'=> 6]],

            'created_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 创建时间...']],

            'updated_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 修改时间...']],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
