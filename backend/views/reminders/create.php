<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Reminders $model
 */

$this->title = 'Create Reminders';
$this->params['breadcrumbs'][] = ['label' => 'Reminders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reminders-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
