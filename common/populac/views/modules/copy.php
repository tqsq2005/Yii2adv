<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = $model->title;
?>
<div class="nav-tabs-custom">
    <?= $this->render('_menu') ?>
    <?= $this->render('_submenu', ['model' => $model]) ?>
    <div style="padding-bottom: 20px;">
        <?php $form = ActiveForm::begin([
            'enableAjaxValidation' => true,
            'options'=>['enctype'=>'multipart/form-data','class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "{label}\n<span class=\"col-md-6\">{input}</span><span class=\"col-md-4\">{error}</span>",
                'labelOptions' => ['class' => 'col-md-2 control-label text-right'],
                //'placeholder' => "{attribute}",
            ],
        ]) ?>
        <?= $form->field($formModel, 'title') ?>
        <?= $form->field($formModel, 'name') ?>
        <div class="col-md-offset-2">
            <?= Html::submitButton(Yii::t('easyii', 'Copy'), ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
