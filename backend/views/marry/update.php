<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Marry $model
 */

$this->title = 'Update Marry: ' . ' ' . $model->mid;
$this->params['breadcrumbs'][] = ['label' => 'Marries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->mid, 'url' => ['view', 'id' => $model->mid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="marry-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
