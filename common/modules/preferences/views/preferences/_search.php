<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\modules\preferences\models\PreferencesSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="preferences-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'codes') ?>

    <?= $form->field($model, 'name1') ?>

    <?= $form->field($model, 'changemark') ?>

    <?= $form->field($model, 'classmark') ?>

    <?= $form->field($model, 'id') ?>

    <?php // echo $form->field($model, 'classmarkcn') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
