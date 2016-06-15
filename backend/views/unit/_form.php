<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Unit */
/* @var $form yii\widgets\ActiveForm */
/* @var integer $isParent */
?>
<div class="box box-success">
    <div class="box-body" id="admin-body">
        <div class="unit-form">
            <?php $form = ActiveForm::begin([
                'id' => 'unit-form',
                'enableClientValidation' => false,
            ]); ?>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'upunitcode')->textInput(['maxlength' => true, 'readOnly' => true]) ?>
                </div>
                <div class="col-md-8">
                    <?= $form->field($model, 'upunitname')->textInput(['maxlength' => true, 'readOnly' => true]) ?>
                    <input type="hidden" id="unit-isParent" value="<?= $isParent?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'unitcode')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-8">
                    <?= $form->field($model, 'unitname')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'office')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-8">
                    <?= $form->field($model, 'address1')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'corporation')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'leader')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'leadertel')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'oname')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'postcode')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'date1')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'corpflag')->dropDownList(\common\populac\models\Preferences::getByClassmark('ukind')) ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-9">
                    <?= Html::submitButton('保 存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php \common\widgets\JsBlock::begin(); ?>
    <script type="text/javascript">
        $(function() {
            //如果主管单位编码是'%'则类型锁定为'单位'
            if ($('#unit-upunitcode').val() == '%') {
                $('#unit-corpflag').attr('readOnly', true);
                $('#unit-corpflag option:not(:selected)').attr('disabled', true);
            }
            //如果主管单位类型是'部门'则类型锁定为'部门'
            if ($('#unit-isParent').val() == 'no') {
                $('#unit-corpflag').attr('readOnly', true);
                $('#unit-corpflag option:not(:selected)').attr('disabled', true);
            }
            //获取单位类型
            var corpflag = $("#unit-corpflag option:selected").val();
            //部门的话掩藏列：法人代表、党政一把手、党政联系电话
            if (corpflag == '5') {
                $('div.field-unit-corporation, div.field-unit-leader, div.field-unit-leadertel').addClass('hidden');
            }

            $(document).on('change', '#unit-corpflag', function() {
                //单位
                if ($(this).val() == '4') {
                    $('div.field-unit-corporation, div.field-unit-leader, div.field-unit-leadertel').removeClass('hidden');
                } else if ($(this).val() == '5') {//部门
                    $('div.field-unit-corporation, div.field-unit-leader, div.field-unit-leadertel').addClass('hidden');
                }
            });
            //form 验证
            $('#unit-form').formValidation({
                framework: 'bootstrap',
                excluded: ':disabled',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    "Unit[unitcode]": {
                        validators: {
                            notEmpty: {
                                message: '单位编码不能为空！'
                            }
                        }
                    },
                    "Unit[unitname]": {
                        validators: {
                            notEmpty: {
                                message: '单位名称不能为空！'
                            }
                        }
                    }
                }
            });
        });
    </script>
<?php \common\widgets\JsBlock::end(); ?>

