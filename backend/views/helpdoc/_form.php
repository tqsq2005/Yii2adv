<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\Helpdoc $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="helpdoc-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [

'author'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 作者...', 'maxlength'=>30]], 

'title'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 标题...', 'maxlength'=>100]], 

'content'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter 内容...','rows'=> 6]], 

'status'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 是否启用...']], 

'upid'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 上级ID...']], 

'created_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Created At...']], 

'updated_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Updated At...']], 

    ]


    ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
