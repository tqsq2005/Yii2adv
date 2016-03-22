<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Preferences $model
 * @var yii\widgets\ActiveForm $form
 */

?>
<div class="preferences-form">

    <?php $form = ActiveForm::begin([
        'id'    => 'preferences-form',//确保ajax验证的时候还在Modal中
        'type'  => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => [
            'labelSpan' => 3,
        ]
    ]); echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'columnSize' => Form::SIZE_LARGE,
    'attributes' => [

'codes'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 参数编码...', 'maxlength'=>4]],

'name1'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 参数名称...', 'maxlength'=>80]], 

'classmark'=>['type'=> Form::INPUT_TEXT, 'options'=>[
    'placeholder'=>'Enter 项目分类-英文...',
    'maxlength'=>30,
    'value' => ($model->isNewRecord && Yii::$app->request->get('create-classmark')) ? Yii::$app->request->get('create-classmark') : $model->classmark,
]],

'classmarkcn'=>['type'=> Form::INPUT_TEXT, 'options'=>[
    'placeholder'=>'Enter 项目分类-中文...',
    'maxlength'=>50,
    'value' => ($model->isNewRecord && Yii::$app->request->get('create-classmark')) ? \common\models\Preferences::getClassmarkcnByClassmark(Yii::$app->request->get('create-classmark')) : $model->classmarkcn,
]],

'status'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'items' => $model->getStatusOptions()],

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


