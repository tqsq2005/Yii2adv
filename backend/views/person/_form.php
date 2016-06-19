<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Personal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="personal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sex')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birthdate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mz')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'marry')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'marrydate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hkaddr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'postcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hkxz')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'work1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'whcd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_dy')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'zw')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'grous')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'obect1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'flag')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'childnum')->textInput() ?>

    <?= $form->field($model, 'unit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jobdate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ingoingdate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'memo1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lhdate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'zhdate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'picture_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'onlysign')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'selfno')->textInput() ?>

    <?= $form->field($model, 'ltunit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ltaddr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ltman')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lttel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ltpostcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'memo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cztype')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'carddate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'examinedate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cardcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fzdw')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'feeddate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'yzdate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'checkunit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'incity')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'memo2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 's_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'logout')->textInput() ?>

    <?= $form->field($model, 'e_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'personal_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'do_man')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'marrowdate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'oldunit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'leavedate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'checktime')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'audittime')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
