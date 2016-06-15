<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mdm\admin\models\Menu;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\Menu */
/* @var $form yii\widgets\ActiveForm */
$this->registerCss('.ui-autocomplete { position: absolute; cursor: default;z-index:1051 !important;}');
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin([
        'id'    => 'menu-form',
        'options'=>['enctype'=>'multipart/form-data','class' => 'form-horizontal'],
        'enableClientValidation' => true,
        //'enableAjaxValidation' => true,//效率低，一般建议局部field开启ajax验证
        //'enableClientValidation' => false,
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-lg-offset-3 col-lg-9\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-3 control-label'],
            //'placeholder' => "{attribute}",
        ],
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 128]) ?>

    <?= $form->field($model, 'parent_name')->widget('yii\jui\AutoComplete',[
        'options'=>['class'=>'form-control'],
        'clientOptions'=>[
            'source'=>  Menu::find()->select(['name'])->column()
        ]
    ]); ?>

    <?= $form->field($model, 'route')->widget('yii\jui\AutoComplete',[
        'options'=>['class'=>'form-control'],
        'clientOptions'=>[
            'source'=> Menu::getSavedRoutes()
        ]
    ]) ?>

    <?= $form->field($model, 'order')->input('number') ?>

    <?= $form->field($model, 'data')->widget(\common\widgets\Iconpicker::className(),[
        'rows'=>6,
        'columns'=>8,
        'iconset'=>'fontawesome'
    ])->label('请选择一个图标..'); ?>

    <div class="form-group">
        <div class="col-lg-offset-3">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('rbac-admin', 'Create') : Yii::t('rbac-admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php \common\widgets\JsBlock::begin(); ?>
    <script type="text/javascript">
        $(function() {
            //form 验证
            $('#menu-form').formValidation({
                framework: 'bootstrap',
                excluded: ':disabled',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    "Menu[name]": {
                        validators: {
                            notEmpty: {
                                message: '*此项必填*'
                            }
                        }
                    },
                    "Menu[parent_name]": {
                        validators: {
                            notEmpty: {
                                message: '*此项必填*'
                            }
                        }
                    }
                }
            });
        });
    </script>
<?php \common\widgets\JsBlock::end(); ?>
