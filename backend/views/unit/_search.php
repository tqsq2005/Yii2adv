<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UnitSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unit-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'unitcode') ?>

    <?= $form->field($model, 'unitname') ?>

    <?= $form->field($model, 'corporation') ?>

    <?= $form->field($model, 'address1') ?>

    <?= $form->field($model, 'office') ?>

    <?php // echo $form->field($model, 'oname') ?>

    <?php // echo $form->field($model, 'tel') ?>

    <?php // echo $form->field($model, 'fax') ?>

    <?php // echo $form->field($model, 'unitkind') ?>

    <?php // echo $form->field($model, 'rank') ?>

    <?php // echo $form->field($model, 'corpflag') ?>

    <?php // echo $form->field($model, 'rsystem') ?>

    <?php // echo $form->field($model, 'upunitname') ?>

    <?php // echo $form->field($model, 'upunitcode') ?>

    <?php // echo $form->field($model, 'postcode') ?>

    <?php // echo $form->field($model, 'char1') ?>

    <?php // echo $form->field($model, 'date1') ?>

    <?php // echo $form->field($model, 'leader') ?>

    <?php // echo $form->field($model, 'leadertel') ?>

    <?php // echo $form->field($model, 'jsxzdate') ?>

    <?php // echo $form->field($model, 'jsxhdate') ?>

    <?php // echo $form->field($model, 'jsbdate') ?>

    <?php // echo $form->field($model, 'id') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
