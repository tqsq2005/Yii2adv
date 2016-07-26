<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use common\populac\models\Preferences;
use kartik\widgets\Select2;

/**
 * @var yii\web\View $this
 * @var common\models\Personal $model
 * @var yii\widgets\ActiveForm $form
 * @var string $unitname
 */

$css = <<<CSS
div.required label:after {
    content: " *";
    color: red;
}
label {
    font-weight: normal !important;
}
CSS;
$this->registerCss($css);
?>

<div class="personal-form">


    <div class="row">
        <div class="col-sm-3 pull-right">
            <?php
            echo \common\components\cropper\CropAvatarWidget::widget([
                'imgSrc' => strlen($model->picture_name) > 14 ? Yii::$app->homeUrl.'/uploads/personCardPhoto/' . $model->personal_id . '/' . $model->picture_name : '',
                'imgSavePath' => '/uploads/personCardPhoto/' . $model->personal_id . '/',
                'imgClass' => 'profile-user-img img-responsive img-rounded',
                'imgCropType' => common\components\cropper\CropAvatarWidget::PERSON_AVATAR,
                'imgPersonalID' => $model->personal_id
            ]);
            ?>
        </div>
        <div class="col-sm-9">
            <?php $form = ActiveForm::begin([
                //'type'=>ActiveForm::TYPE_HORIZONTAL,
                //'formConfig'=>['labelSpan'=>5],
                //'enableClientValidation' => false,
                'id' => 'personal-form'
            ]);
            ?>
            <div class="row">
                <div class="col-sm-12">
                    <?php
                    echo Html::submitButton('保 存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-info']);
                    ?>
                </div>
            </div>
            <?php
            echo Form::widget([
                'model' => $model,
                'form' => $form,
                'columns' => 6,
                //'staticOnly' => !($model->isNewRecord),
                'attributes' => [
                    'personal_id'=>['type'=> Form::INPUT_HIDDEN, 'label' => false, 'columnOptions'=>['colspan'=>0],],

                    's_date'=>['type'=> Form::INPUT_TEXT, 'columnOptions'=>['colspan'=>2], 'options'=>['placeholder'=>'请输入登记日期..', 'maxlength'=>8]],

                    'code1'=>['type'=> Form::INPUT_TEXT, 'columnOptions'=>['colspan'=>2], 'options'=>['placeholder'=>'请输入员工编码..', 'maxlength'=>36]],

                    'name1'=>['type'=> Form::INPUT_TEXT, 'columnOptions'=>['colspan'=>2], 'options'=>['placeholder'=>'请输入员工姓名..', 'maxlength'=>50]],
                ]

            ]);
            ?>
        </div>

        <div class="col-sm-12">
            <?php
            echo Form::widget([

                'model' => $model,
                'form' => $form,
                'columns' => 4,
                //'staticOnly' => !($model->isNewRecord),
                'attributes' => [

                    //'picture_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['rowspan' => 2, 'maxlength'=>100]],
                    'fcode'=>['type'=> Form::INPUT_TEXT, 'options'=>['id' => 'p-fcode', 'placeholder'=>'身份证号', 'maxlength'=>18]],

                    'sex'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'items' => Preferences::getByClassmark('psex'), 'options'=>['id'=>'p-sex', 'readOnly' => true]],

                    'birthdate'=>['type'=> Form::INPUT_TEXT, 'options'=>['id'=>'p-birthdate', 'placeholder'=>'请输入出生日期..', 'maxlength'=>8, 'readOnly' => true]],

                    'unit'=>['type'=> Form::INPUT_TEXT, 'options'=>['id'=>'p-unit', 'readOnly' => true, 'maxlength'=>30]],

                    'flag'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'items' => Preferences::getByClassmark('pflag'), 'options'=>['placeholder'=>'Enter Flag...', 'maxlength'=>2]],

                    'hkxz'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'items' => Preferences::getByClassmark('chkxz'), 'options'=>['placeholder'=>'Enter Hkxz...', 'maxlength'=>2]],

                    'marry'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'items' => Preferences::getByClassmark('pmarry'), 'options'=>['id'=>'p-marry', 'placeholder'=>'Enter Marry...', 'maxlength'=>2]],

                    'marrydate'=>['type'=> Form::INPUT_TEXT, 'options'=>['id'=>'p-marrydate', 'placeholder'=>'Enter Marrydate...', 'maxlength'=>8]],

                    'memo1'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'items' => Preferences::getByClassmark('pmemo1'), 'options'=>['placeholder'=>'Enter Memo1...', 'maxlength'=>2]],

                    'selfno'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Selfno...']],

                    'lhdate'=>['type'=> Form::INPUT_TEXT, 'options'=>['id'=>'p-lhdate', 'placeholder'=>'Enter Lhdate...', 'maxlength'=>8]],

                    'zhdate'=>['type'=> Form::INPUT_TEXT, 'options'=>['id'=>'p-zhdate', 'maxlength'=>8]],

                    'work1'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'items' => Preferences::getByClassmark('pwork1'), 'options'=>['placeholder'=>'Enter Work1...', 'maxlength'=>2]],

                    'childnum'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Childnum...']],

                    //'obect1'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'items' => \yii\helpers\ArrayHelper::merge(['' => '--请选择--'], Preferences::getByClassmark('pobect1')), 'options'=>['placeholder'=>'Enter Obect1...', 'maxlength'=>2]],
                    'obect1'=>[
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => Select2::className(),
                        'options' => [
                            'data'=>Preferences::getByClassmark('pobect1'),
                            'options' => ['placeholder' => '--请选择--'],
                            'pluginOptions' => ['allowClear' => true,],
                        ],
                    ],

                    'fhdate'=>['type'=> Form::INPUT_TEXT, 'options'=>['id'=>'p-fhdate', 'maxlength'=>8]],

                    'mz'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'items' => Preferences::getByClassmark('pmz'), 'options'=>['placeholder'=>'Enter Mz...', 'maxlength'=>2]],

                    'whcd'=>[
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => Select2::className(),
                        'options' => [
                            'data'=>Preferences::getByClassmarkReturnName1ToName1('pwhcd'),
                            'options' => [
                                'placeholder' => '请输入..',
                                'id' => 'p-whcd',
                                'data-classmark' => 'pwhcd',
                                'data-classmarkcn' => '文化程度'
                            ],
                            'pluginOptions' => [
                                //'allowClear' => true,
                                'tags' => true,
                                'tokenSeparators' => [',', ' '],
                                'maximumInputLength' => 10
                            ],
                        ],
                    ],

                    //'title'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Title...', 'maxlength'=>50]],
                    'title'=>[
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => Select2::className(),
                        'options' => [
                            'data'=>Preferences::getByClassmarkReturnName1ToName1('ptitle'),
                            'options' => [
                                'placeholder' => '请输入..',
                                'id' => 'p-title',
                                'data-classmark' => 'ptitle',
                                'data-classmarkcn' => '职称'
                            ],
                            'pluginOptions' => [
                                //'allowClear' => true,
                                'tags' => true,
                                'tokenSeparators' => [',', ' '],
                                'maximumInputLength' => 10
                            ],
                        ],
                    ],

                    'zw'=>[
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => Select2::className(),
                        'options' => [
                            'data'=>Preferences::getByClassmarkReturnName1ToName1('awork1'),
                            'options' => [
                                'placeholder' => '请输入..',
                                'id' => 'p-zw',
                                'data-classmark' => 'awork1',
                                'data-classmarkcn' => '职务'
                            ],
                            'pluginOptions' => [
                                //'allowClear' => true,
                                'tags' => true,
                                'tokenSeparators' => [',', ' '],
                                'maximumInputLength' => 10
                            ],
                        ],
                    ],

                    'is_dy'=>[
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => Select2::className(),
                        'options' => [
                            'data'=>Preferences::getByClassmarkReturnName1ToName1('pis_dy'),
                            'options' => [
                                'placeholder' => '请输入..',
                                'id' => 'p-is_dy',
                                'data-classmark' => 'pis_dy',
                                'data-classmarkcn' => '政治面貌'
                            ],
                            'pluginOptions' => [
                                //'allowClear' => true,
                                'tags' => true,
                                'tokenSeparators' => [',', ' '],
                                'maximumInputLength' => 10
                            ],
                        ],
                    ],

                    'onlysign'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'items' => Preferences::getByClassmark('ponlysign'), 'options'=>['placeholder'=>'Enter Onlysign...', 'maxlength'=>2]],

                    'tel'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Tel...', 'maxlength'=>50]],

                    'jobdate'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Jobdate...', 'maxlength'=>8]],

                    'address1'=>['type'=> Form::INPUT_TEXT, 'columnOptions'=>['colspan'=>2], 'options'=>['placeholder'=>'Enter Address1...', 'maxlength'=>80]],

                    'grous'=>[
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => Select2::className(),
                        'options' => [
                            'data'=>Preferences::getByClassmarkReturnName1ToName1('pgrous'),
                            'options' => [
                                'placeholder' => '请输入..',
                                'id' => 'p-grous',
                                'data-classmark' => 'pgrous',
                                'data-classmarkcn' => '所属街道'
                            ],
                            'pluginOptions' => [
                                //'allowClear' => true,
                                'tags' => true,
                                'tokenSeparators' => [',', ' '],
                                'maximumInputLength' => 10
                            ],
                        ],
                    ],

                    'ingoingdate'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Ingoingdate...', 'maxlength'=>8]],

                    //'postcode'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Postcode...', 'maxlength'=>10]],



                    //'ltunit'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Ltunit...', 'maxlength'=>80]],

                    //'ltman'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Ltman...', 'maxlength'=>50]],

                    //'ltpostcode'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Ltpostcode...', 'maxlength'=>10]],

                    //'ltaddr'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Ltaddr...', 'maxlength'=>80]],

                    //'lttel'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Lttel...', 'maxlength'=>50]],





                ]

            ]);

            echo Form::widget([

                'model' => $model,
                'form' => $form,
                'columns' => 4,
                //'staticOnly' => !($model->isNewRecord),
                'attributes' => [
                    'hkaddr'=>['type'=> Form::INPUT_TEXT, 'columnOptions'=>['colspan'=>2], 'options'=>['placeholder'=>'Enter Hkaddr...', 'maxlength'=>80]],

                    //'audittime'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Audittime...', 'maxlength'=>10]],

                    'logout'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'items' => Preferences::getByClassmark('plogout'), 'options'=>['placeholder'=>'Enter Logout...']],

                    'e_date'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter E Date...', 'maxlength'=>8]],

                ]

            ]);

            echo Form::widget([

                'model' => $model,
                'form' => $form,
                'columns' => 4,
                //'staticOnly' => !($model->isNewRecord),
                'attributes' => [
                    'memo'=>['type'=> Form::INPUT_TEXT, 'columnOptions'=>['colspan'=>2],  'options'=>['placeholder'=>'Enter Memo...', 'maxlength'=>254]],

                    'checktime'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'items' => Preferences::getByClassmark('pchecktime'), 'options'=>['id'=>'p-checktime', 'placeholder'=>'Enter Checktime...', 'maxlength'=>2]],

                ]

            ]);


            ActiveForm::end(); ?>
        </div>
    </div>

</div>

<?php \common\widgets\JsBlock::begin(); ?>
    <script type="text/javascript">
        //身份证合法性
        function certificateNoParse(certificateNo){
            var pat = /^\d{6}(((19|20)\d{2}(0[1-9]|1[0-2])(0[1-9]|[1-2][0-9]|3[0-1])\d{3}([0-9]|x|X))|(\d{2}(0[1-9]|1[0-2])(0[1-9]|[1-2][0-9]|3[0-1])\d{3}))$/;
            if(!pat.test(certificateNo))
                return null;

            var parseInner = function(certificateNo, idxSexStart, birthYearSpan){
                var res = {};
                var idxSex = 1 - certificateNo.substr(idxSexStart, 1) % 2;
                res.sex = idxSex == '1' ? '02' : '01';

                var year = (birthYearSpan == 2 ? '19' : '') +
                    certificateNo.substr(6, birthYearSpan);
                var month = certificateNo.substr(6 + birthYearSpan, 2);
                var day = certificateNo.substr(8 + birthYearSpan, 2);
                res.birthday = year + '' + month + '' + day;

                var d = new Date(); //当然，在正式项目中，这里应该获取服务器的当前时间
                var monthFloor = ((d.getMonth()+1) < parseInt(month,10) || (d.getMonth()+1) == parseInt(month,10) && d.getDate() < parseInt(day,10)) ? 1 : 0;
                res.age = d.getFullYear() - parseInt(year,10) - monthFloor;
                return res;
            };

            return parseInner(certificateNo, certificateNo.length == 15 ? 14 : 16, certificateNo.length == 15 ? 2 : 4);
        };

        $(function() {
            <?php if(!$model->isNewRecord) { ?>
            $('#p-checktime').siblings('label').text('<?= $model->sex ?>' == '01' ? '函调次数' : '妇检次数');
            <?php } else { ?>
            $('#p-unit').siblings('label').html('所在部门(<span class="text-danger"><?=$unitname?></span>)');
            var avatar_view = '<div class="avatar-view-only" title="保存基础档案信息后才能上传头像" data-toggle="tooltip">' +
                '<img class="profile-user-img img-responsive img-rounded" alt="Avatar" src="/admin/uploads/user/default/user2-160x160.jpg">' +
                '</div>';
            $('div#crop-avatar').html(avatar_view);
            <?php } ?>
            //更改checktime的label

            //更改 placeholder
            $('div.personal-form input[type=text]').each(function(i) {
                var label = $(this).siblings('label').text();
                //$(this).prop('placeholder', '请输入『' + label + '』..');
                $(this).prop('placeholder', '');
            });

            //表单验证
            $('#personal-form')
                .formValidation({
                    framework: 'bootstrap',
                    excluded: ':disabled',
                    icon: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        "Personal[fcode]": {
                            validators: {
                                notEmpty: {
                                    message: '请输入身份证号'
                                },
                                callback: {
                                    callback: function(value, validator, $field) {
                                        var $focde  = validator.getFieldElements('Personal[fcode]'),
                                            fcode   = $focde.val(),
                                            res     = certificateNoParse(fcode);

                                        if ( !res ) {
                                            return {
                                                valid: false,
                                                message: '请输入正确的身份证号'
                                            };
                                        }
                                        validator.updateStatus('Personal[fcode]', validator.STATUS_VALID, 'callback');
                                        return true;
                                    }
                                }
                            }
                        },
                        "Personal[e_date]": {
                            validators: {
                                stringLength: {
                                    message: '日期格式YYYYMMDD',
                                    max: 8,
                                    min: 8
                                }
                            }
                        }
                    }
                })
                //输入身份证，自动生成性别及出生日期
                .on('keyup blur', '#p-fcode', function() {
                    var fcode = $(this).val();
                    var res   = certificateNoParse(fcode);
                    if ( res ) {
                        $('#p-sex').val(res.sex);
                        $('#p-birthdate').val(res.birthday);
                        $('#p-checktime').siblings('label').text(res.sex == '01' ? '函调次数' : '妇检次数');
                    }
                })
                .on('select2:select', '#p-title, #p-zw, #p-whcd, #p-is_dy, #p-grous', function() {
                    var title       = $(this).val(),
                        classmark   = $(this).attr('data-classmark'),
                        classmarkcn = $(this).attr('data-classmarkcn');

                    $.ajax({
                        url: '<?= \yii\helpers\Url::to(['/populac/preferences/exists'])?>',
                        data: { classmark: classmark, name1: title },
                        type: 'post',
                        beforeSend: function () {
                            layer.load(1);
                        },
                        complete: function () {
                            layer.closeAll('loading');
                        },
                        error: function() {
                            console.log('通讯出错..');
                        },
                        success: function(data, textStatus){
                            if( data == 'no' ) {
                                var shiftNum = [0, 1, 2, 3, 4, 5, 6];
                                var confirmMsg = '『' + classmarkcn + '』配置选项中不包含『' + title + '』,是否需要将『' + title + '』添加到『' + classmarkcn + '』配置选项中？';
                                layer.confirm(confirmMsg, {
                                    title: '系统提示',
                                    shift: shiftNum[Math.floor(Math.random()*shiftNum.length)],
                                    icon: 6,
                                    scrollbar: false
                                }, function(index) {
                                    $.ajax({
                                        url: '<?= \yii\helpers\Url::to(['/populac/preferences/add'])?>',
                                        data: { classmark: classmark, name1: title },
                                        type: 'POST',
                                        success: function(data){
                                            if( data == 'success' ) {
                                                layer.msg('已保存', { icon: 6, time: 1000 });
                                            }
                                        },
                                        error: function(e){
                                            console.log(e.responseText);
                                        }
                                    });
                                    layer.close(index);
                                });
                            }
                        }
                    });
                });
        });
    </script>
<?php \common\widgets\JsBlock::end(); ?>
