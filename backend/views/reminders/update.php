<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Reminders $model
 */

$this->title = 'Update Reminders: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Reminders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="reminders-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
