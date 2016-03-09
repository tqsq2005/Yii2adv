<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var backend\models\PersonalSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="personal-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'code1') ?>

    <?= $form->field($model, 'name1') ?>

    <?= $form->field($model, 'sex') ?>

    <?= $form->field($model, 'birthdate') ?>

    <?= $form->field($model, 'fcode') ?>

    <?php // echo $form->field($model, 'mz') ?>

    <?php // echo $form->field($model, 'marry') ?>

    <?php // echo $form->field($model, 'marrydate') ?>

    <?php // echo $form->field($model, 'address1') ?>

    <?php // echo $form->field($model, 'hkaddr') ?>

    <?php // echo $form->field($model, 'tel') ?>

    <?php // echo $form->field($model, 'postcode') ?>

    <?php // echo $form->field($model, 'hkxz') ?>

    <?php // echo $form->field($model, 'work1') ?>

    <?php // echo $form->field($model, 'whcd') ?>

    <?php // echo $form->field($model, 'is_dy') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'zw') ?>

    <?php // echo $form->field($model, 'grous') ?>

    <?php // echo $form->field($model, 'obect1') ?>

    <?php // echo $form->field($model, 'flag') ?>

    <?php // echo $form->field($model, 'childnum') ?>

    <?php // echo $form->field($model, 'unit') ?>

    <?php // echo $form->field($model, 'jobdate') ?>

    <?php // echo $form->field($model, 'ingoingdate') ?>

    <?php // echo $form->field($model, 'memo1') ?>

    <?php // echo $form->field($model, 'lhdate') ?>

    <?php // echo $form->field($model, 'zhdate') ?>

    <?php // echo $form->field($model, 'picture_name') ?>

    <?php // echo $form->field($model, 'onlysign') ?>

    <?php // echo $form->field($model, 'selfno') ?>

    <?php // echo $form->field($model, 'ltunit') ?>

    <?php // echo $form->field($model, 'ltaddr') ?>

    <?php // echo $form->field($model, 'ltman') ?>

    <?php // echo $form->field($model, 'lttel') ?>

    <?php // echo $form->field($model, 'ltpostcode') ?>

    <?php // echo $form->field($model, 'memo') ?>

    <?php // echo $form->field($model, 'cztype') ?>

    <?php // echo $form->field($model, 'carddate') ?>

    <?php // echo $form->field($model, 'examinedate') ?>

    <?php // echo $form->field($model, 'cardcode') ?>

    <?php // echo $form->field($model, 'fzdw') ?>

    <?php // echo $form->field($model, 'feeddate') ?>

    <?php // echo $form->field($model, 'yzdate') ?>

    <?php // echo $form->field($model, 'checkunit') ?>

    <?php // echo $form->field($model, 'incity') ?>

    <?php // echo $form->field($model, 'memo2') ?>

    <?php // echo $form->field($model, 's_date') ?>

    <?php // echo $form->field($model, 'logout') ?>

    <?php // echo $form->field($model, 'e_date') ?>

    <?php // echo $form->field($model, 'personal_id') ?>

    <?php // echo $form->field($model, 'do_man') ?>

    <?php // echo $form->field($model, 'marrowdate') ?>

    <?php // echo $form->field($model, 'oldunit') ?>

    <?php // echo $form->field($model, 'leavedate') ?>

    <?php // echo $form->field($model, 'checktime') ?>

    <?php // echo $form->field($model, 'audittime') ?>

    <?php // echo $form->field($model, 'id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
