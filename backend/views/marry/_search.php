<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var backend\models\MarrySearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="marry-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'code1') ?>

    <?= $form->field($model, 'marrow') ?>

    <?= $form->field($model, 'because') ?>

    <?= $form->field($model, 'becausedate') ?>

    <?php // echo $form->field($model, 'mfcode') ?>

    <?php // echo $form->field($model, 'mhkdz') ?>

    <?php // echo $form->field($model, 'marrowdate') ?>

    <?php // echo $form->field($model, 'marrowunit') ?>

    <?php // echo $form->field($model, 'othertel') ?>

    <?php // echo $form->field($model, 'hfp') ?>

    <?php // echo $form->field($model, 'maddr') ?>

    <?php // echo $form->field($model, 'mpostcode') ?>

    <?php // echo $form->field($model, 'marrowno') ?>

    <?php // echo $form->field($model, 'hmarry') ?>

    <?php // echo $form->field($model, 'marrycode') ?>

    <?php // echo $form->field($model, 'mem') ?>

    <?php // echo $form->field($model, 'unit') ?>

    <?php // echo $form->field($model, 'personal_id') ?>

    <?php // echo $form->field($model, 'do_man') ?>

    <?php // echo $form->field($model, 'mid') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
