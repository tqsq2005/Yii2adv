<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\populac\models\MapTable */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="map-table-form">

    <?php $form = ActiveForm::begin([
        'id'    => 'map-table-form',
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
    <?php
        if( $model->isNewRecord ) {
            echo $form->field($model, 'tname')->widget(\kartik\widgets\Select2::classname(), [
                'data' => \common\populac\models\MapTable::getLostTables(),
                'options' => ['placeholder' => '选择一个表..'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
        } else {
            echo $form->field($model, 'tname')->textInput(['readOnly' => true]);
        }

    ?>

    <?= $form->field($model, 'cnname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'memo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_num')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList(\common\populac\models\Preferences::getByClassmark('sStatus')) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
