<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Personal */

$this->title = 'Update Personal: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Personals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="personal-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
