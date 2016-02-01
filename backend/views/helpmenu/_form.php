<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\Helpmenu $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="helpmenu-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [

'unitcode'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Unitcode...', 'maxlength'=>30]], 

'unitname'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Unitname...', 'maxlength'=>50]], 

'upunitcode'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Upunitcode...', 'maxlength'=>30]], 

'upunitname'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Upunitname...', 'maxlength'=>50]], 

'corpflag'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Corpflag...']], 

'content'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter Content...','rows'=> 6]], 

'introduce'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter Introduce...','rows'=> 6]], 

'do_man'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Do Man...', 'maxlength'=>30]], 

'do_date'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]], 

'do_man_unit'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Do Man Unit...', 'maxlength'=>30]], 

'advise'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter Advise...','rows'=> 6]], 

'answer'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Answer...', 'maxlength'=>30]], 

'answerdate'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]], 

'is_private'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Is Private...']], 

'answercontent'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter Answercontent...','rows'=> 6]], 

'created_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Created At...']], 

'updated_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Updated At...']], 

    ]


    ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
