<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\Marry $model
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

'personal_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Personal ID...', 'maxlength'=>60]], 

'marrowno'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Marrowno...']], 

'code1'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Code1...', 'maxlength'=>36]], 

'marrow'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Marrow...', 'maxlength'=>50]], 

'othertel'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Othertel...', 'maxlength'=>50]], 

'marrycode'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Marrycode...', 'maxlength'=>50]], 

'do_man'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Do Man...', 'maxlength'=>50]], 

'because'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Because...', 'maxlength'=>2]], 

'hfp'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Hfp...', 'maxlength'=>2]], 

'hmarry'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Hmarry...', 'maxlength'=>2]], 

'becausedate'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Becausedate...', 'maxlength'=>10]], 

'marrowdate'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Marrowdate...', 'maxlength'=>10]], 

'mpostcode'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Mpostcode...', 'maxlength'=>10]], 

'mfcode'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Mfcode...', 'maxlength'=>18]], 

'mhkdz'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Mhkdz...', 'maxlength'=>80]], 

'marrowunit'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Marrowunit...', 'maxlength'=>80]], 

'maddr'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Maddr...', 'maxlength'=>80]], 

'mem'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Mem...', 'maxlength'=>100]], 

'unit'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Unit...', 'maxlength'=>30]], 

    ]


    ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
