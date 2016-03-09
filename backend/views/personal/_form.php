<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\Personal $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="personal-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [

'childnum'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Childnum...']], 

'selfno'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Selfno...']], 

'logout'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Logout...']], 

'personal_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Personal ID...', 'maxlength'=>60]], 

'code1'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Code1...', 'maxlength'=>36]], 

'name1'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Name1...', 'maxlength'=>50]], 

'tel'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Tel...', 'maxlength'=>50]], 

'whcd'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Whcd...', 'maxlength'=>50]], 

'is_dy'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Is Dy...', 'maxlength'=>50]], 

'title'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Title...', 'maxlength'=>50]], 

'zw'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Zw...', 'maxlength'=>50]], 

'ltman'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Ltman...', 'maxlength'=>50]], 

'lttel'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Lttel...', 'maxlength'=>50]], 

'cardcode'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Cardcode...', 'maxlength'=>50]], 

'do_man'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Do Man...', 'maxlength'=>50]], 

'sex'=>[
    'type'=> Form::INPUT_WIDGET,
    'widgetClass' => '\kartik\widgets\Select2',
    'options'=>[
        'data' => \yii\helpers\ArrayHelper::map(\common\models\Preferences::find()->where(['classmark' => 'psex'])->all(), 'codes', 'name1'),
        'options' => ['placeholder' => '---请选择性别---'],
    ],
],

'mz'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Mz...', 'maxlength'=>2]], 

'marry'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Marry...', 'maxlength'=>2]], 

'hkxz'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Hkxz...', 'maxlength'=>2]], 

'work1'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Work1...', 'maxlength'=>2]], 

'obect1'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Obect1...', 'maxlength'=>2]], 

'flag'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Flag...', 'maxlength'=>2]], 

'memo1'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Memo1...', 'maxlength'=>2]], 

'onlysign'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Onlysign...', 'maxlength'=>2]], 

'cztype'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Cztype...', 'maxlength'=>2]], 

'incity'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Incity...', 'maxlength'=>2]], 

'checktime'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Checktime...', 'maxlength'=>2]], 

'birthdate'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Birthdate...', 'maxlength'=>10]], 

'marrydate'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Marrydate...', 'maxlength'=>10]], 

'postcode'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Postcode...', 'maxlength'=>10]], 

'jobdate'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Jobdate...', 'maxlength'=>10]], 

'ingoingdate'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Ingoingdate...', 'maxlength'=>10]], 

'lhdate'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Lhdate...', 'maxlength'=>10]], 

'zhdate'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Zhdate...', 'maxlength'=>10]], 

'ltpostcode'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Ltpostcode...', 'maxlength'=>10]], 

'carddate'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Carddate...', 'maxlength'=>10]], 

'examinedate'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Examinedate...', 'maxlength'=>10]], 

'feeddate'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Feeddate...', 'maxlength'=>10]], 

'yzdate'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Yzdate...', 'maxlength'=>10]], 

's_date'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter S Date...', 'maxlength'=>10]], 

'e_date'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter E Date...', 'maxlength'=>10]], 

'marrowdate'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Marrowdate...', 'maxlength'=>10]], 

'leavedate'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Leavedate...', 'maxlength'=>10]], 

'audittime'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Audittime...', 'maxlength'=>10]], 

'fcode'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Fcode...', 'maxlength'=>18]], 

'address1'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Address1...', 'maxlength'=>80]], 

'hkaddr'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Hkaddr...', 'maxlength'=>80]], 

'ltunit'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Ltunit...', 'maxlength'=>80]], 

'ltaddr'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Ltaddr...', 'maxlength'=>80]], 

'fzdw'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Fzdw...', 'maxlength'=>80]], 

'checkunit'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Checkunit...', 'maxlength'=>80]], 

'grous'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Grous...', 'maxlength'=>30]], 

'unit'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Unit...', 'maxlength'=>30]], 

'oldunit'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Oldunit...', 'maxlength'=>30]], 

'picture_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Picture Name...', 'maxlength'=>100]], 

'memo2'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Memo2...', 'maxlength'=>100]], 

'memo'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Memo...', 'maxlength'=>254]], 

    ]


    ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
