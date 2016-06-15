<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Helpdoc */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="helpdoc-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'upid')->widget(\kartik\widgets\Select2::className(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\Helpdoc::findAll(['status' => 1]), 'id', 'title'),
        'options' => ['placeholder' => '请选择上级标题'],
        'pluginOptions' => [
            'allowClear' => true,
            'tags' => true,
            'tokenSeparators' => [',', ' '],
            'maximumInputLength' => 50,
        ],
    ]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tagNames')->widget(\dosamigos\selectize\SelectizeTextInput::className(), [
        // calls an action that returns a JSON object with matched
        // tags
        'loadUrl' => ['tag/list'],
        'options' => ['class' => 'form-control'],
        'clientOptions' => [
            'plugins' => ['remove_button'],
            'valueField' => 'name',
            'labelField' => 'name',
            'searchField' => ['name'],
            'create' => true,
        ],
    ])->hint('提示：用逗号或者回车键分隔标签') ?>

    <?= $form->field($model, 'content')->widget(\kucha\ueditor\UEditor::className(), [
        'clientOptions' => [
            //编辑区域大小
            'initialFrameHeight' => '200',
            //设置语言
            'lang' =>'zh-cn', //中文为 zh-cn
            //定制菜单
            'toolbars' => [
                [
                    'fullscreen', 'source', 'undo', 'redo', '|',
                    'fontsize',
                    'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'removeformat',
                    'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|',
                    'forecolor', 'backcolor', '|',
                    'lineheight', '|',
                    'indent', '|'
                ],
            ]
        ]
    ]) ?>

    <?= $form->field($model, 'status')->dropDownList(
        \yii\helpers\ArrayHelper::map(\common\models\Preferences::findAll(['classmark' => 'sStatus', 'status' => 1]), 'codes', 'name1')
    ) ?>


  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? '新增' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
