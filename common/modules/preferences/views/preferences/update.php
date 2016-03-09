<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\modules\preferences\models\Preferences $model
 */

$this->title = 'Update Preferences: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Preferences', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="preferences-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
