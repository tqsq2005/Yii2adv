<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\modules\preferences\models\Preferences $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="preferences-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [

'codes'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 参数编码...', 'maxlength'=>10]], 

'name1'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 参数名称...', 'maxlength'=>80]], 

'classmark'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 项目分类-英文...', 'maxlength'=>10]], 

'classmarkcn'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 项目分类-中文...', 'maxlength'=>50]], 

'created_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 新增时间...']], 

'updated_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 修改时间...']], 

'changemark'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 修改标识...']], 

'status'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 是否启用...']], 

    ]


    ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
