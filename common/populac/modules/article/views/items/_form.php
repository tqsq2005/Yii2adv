<?php
use common\populac\helpers\Image;
use common\populac\widgets\TagsInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\populac\widgets\Redactor;

$module = $this->context->module->id;
\common\populac\assets\AdminAsset::register($this);
?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data', 'class' => 'model-form'],
    'fieldConfig' => [
        'template' => "{label}\n<span class=\"col-md-10\">{input}</span>\n<span class=\"col-md-offset-2 col-md-10\">{error}</span>",
        'labelOptions' => ['class' => 'col-md-2 control-label text-right'],
        //'placeholder' => "{attribute}",
    ],
]); ?>
<?= $form->field($model, 'title') ?>

<?php if($this->context->module->settings['articleThumb']) : ?>
    <?php if($model->image) : ?>
        <div class="col-md-offset-2">
            <img src="<?= Image::thumb($model->image, 240) ?>">
            <a href="<?= Url::to(['/populac/'.$module.'/items/clear-image', 'id' => $model->primaryKey]) ?>"
               class="text-danger confirm-delete" title="<?= Yii::t('easyii', 'Clear image')?>">
                <?= Yii::t('easyii', 'Clear image')?></a>
        </div>
    <?php endif; ?>
    <?= $form->field($model, 'image')->fileInput() ?>
<?php endif; ?>

<?php if($this->context->module->settings['enableShort']) : ?>
    <?= $form->field($model, 'short')->textarea() ?>
<?php endif; ?>

<?= $form->field($model, 'text')->widget(\kucha\ueditor\UEditor::className(), [
    'clientOptions' => [
        //编辑区域大小
        'initialFrameHeight' => '400',
        //设置语言
        'lang' =>'zh-cn', //中文为 zh-cn
        //定制菜单
        /*'toolbars' => [
            [
                'fullscreen', 'source', 'undo', 'redo', '|',
                'fontsize',
                'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'removeformat',
                'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|',
                'forecolor', 'backcolor', '|',
                'lineheight', '|',
                'indent', '|'
            ],
        ]*/
    ]
]) ?>

<?= $form->field($model, 'time')->widget(\kartik\widgets\DateTimePicker::className(), [
    'pluginOptions' => [
        'autoclose' => true,
    ]
]); ?>

<?php if($this->context->module->settings['enableTags']) : ?>
    <?= $form->field($model, 'tagNames')->widget(TagsInput::className()) ?>
<?php endif; ?>

<?php if(IS_ROOT) : ?>
    <?= $form->field($model, 'slug') ?>
<?php endif; ?>
<div class="col-md-offset-2">
    <?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>