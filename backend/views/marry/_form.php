<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Marry $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="marry-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter ID...']],

            'code1'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 个人编码...', 'maxlength'=>36]],

            'marrow'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 配偶姓名...', 'maxlength'=>50]],

            'because'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 与员工婚姻关系...', 'maxlength'=>2]],

            'becausedate'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 发生婚姻关系时间...', 'maxlength'=>10]],

            'mfcode'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 配偶身份证号...', 'maxlength'=>18]],

            'mhkdz'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 配偶户口地址...', 'maxlength'=>80]],

            'marrowdate'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 配偶出生日期...', 'maxlength'=>10]],

            'marrowunit'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 配偶工作单位...', 'maxlength'=>80]],

            'othertel'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 配偶单位电话...', 'maxlength'=>50]],

            'hfp'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 配偶户口性质...', 'maxlength'=>2]],

            'maddr'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 配偶单位地址...', 'maxlength'=>80]],

            'mpostcode'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 配偶单位邮编...', 'maxlength'=>10]],

            'marrowno'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 配偶生育次数...']],

            'hmarry'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 配偶婚姻状况...', 'maxlength'=>2]],

            'marrycode'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 结婚证号...', 'maxlength'=>50]],

            'mem'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 备注...', 'maxlength'=>100]],

            'unit'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Unit...', 'maxlength'=>30]],

            'personal_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Personal ID...', 'maxlength'=>60]],

            'do_man'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Do Man...', 'maxlength'=>50]],

            'created_by'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Created By...']],

            'updated_by'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Updated By...']],

            'created_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Created At...']],

            'updated_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Updated At...']],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
