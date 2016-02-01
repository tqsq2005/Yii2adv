<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var backend\models\HelpmenuSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="helpmenu-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'unitcode') ?>

    <?= $form->field($model, 'unitname') ?>

    <?= $form->field($model, 'upunitcode') ?>

    <?= $form->field($model, 'upunitname') ?>

    <?php // echo $form->field($model, 'corpflag') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'introduce') ?>

    <?php // echo $form->field($model, 'do_man') ?>

    <?php // echo $form->field($model, 'do_date') ?>

    <?php // echo $form->field($model, 'do_man_unit') ?>

    <?php // echo $form->field($model, 'advise') ?>

    <?php // echo $form->field($model, 'answer') ?>

    <?php // echo $form->field($model, 'answerdate') ?>

    <?php // echo $form->field($model, 'is_private') ?>

    <?php // echo $form->field($model, 'answercontent') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
